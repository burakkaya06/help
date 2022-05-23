<?php

namespace App\Controller;

use App\Entity\Debt;
use App\Entity\Installement;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreditController extends AbstractController
{
    /**
     * @Route("/credit", name="app_credit")
     */
    public function index(ManagerRegistry $managerRegistry): Response
    {

        $users = $managerRegistry->getRepository(User::class)->findAll();

        $sql = " 
        select d.*,u.name_surnama
        from debt d
        inner join user u on d.debt_owner_id = u.id
    ";

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        $credits = $stmt->fetchAll();

        foreach ($credits as $key => $credit) {

            $id = $credit['id'];
            $sql = "
        select (select count(*) from installement where debt_id = $id and status = 1)    odenen_taksit_sayisi,
       (select count(*) from installement where debt_id = $id and status = 0)    kalan_taksit_sayisi,
       (select sum(amount) from installement where debt_id = $id and status = 1) odenen_tutar,
       (select sum(amount) from installement where debt_id = $id and status = 0) kalan_tutar,
       i.principal                                                             anaTaksitTutar,
       amount                                                                  odenecekTaksit,
       debt_id,
       dt.name debtType                                                         
from installement i
         left join debt d on d.id = i.debt_id
left join debt_type  dt on d.debt_type_id = dt.id
where debt_id = $id
limit 1";

            $em = $this->getDoctrine()->getManager();
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();
            $installement = $stmt->fetchAll();
            $progress = (floatval($installement[0]['odenen_taksit_sayisi']) / (floatval($installement[0]['odenen_taksit_sayisi']) + floatval($installement[0]['kalan_taksit_sayisi']))) * 100;
            $installement[0]['progress'] = intval($progress);
            $credits[$key]['installement'] = $installement[0];
        }

        $userArr = [];
        foreach ($users as $user) {
            /**
             * @var $user User
             */
            $userArr [] = [
                'id' => $user->getId(),
                'name' => $user->getNameSurnama()
            ];
        }
        return $this->render('credit/index.html.twig', [
            'users' => $userArr,
            'credits'=> $credits
        ]);
    }

    /**
     * @Route("/settings/gider_parent", name="save_credit", methods={"POST"})
     *
     */
    public function saveCredit(Request $request, ManagerRegistry $doctrine): Response
    {
        try {
            $entityManager = $doctrine->getManager();
            $credit = new Debt();
            $credit->setBankInfo($request->request->get("bank_info"));
            $credit->setDebtOwnerId($request->request->get("cerdit_name"));
            $credit->setInstallementCount($request->request->get("credit_installement"));
            $credit->setTotalAmount($request->request->get("cekilen_tutar"));
            $credit->setPrincipal($request->request->get("ana_para"));
            $credit->setInstallementCount($request->request->get("credit_installement"));
            $credit->setDebtTypeId(2);
            $credit->setStatus(1);
            $credit->setDebtStartDate(\DateTime::createFromFormat('Y-m-d', $request->request->get("ilk_cekildigi_tarih")));
            $credit->setImageUrl($request->request->get("kurl"));
            $entityManager->persist($credit);
            $entityManager->flush();
            $requestArr = $request->request->all();
            for ($i = 1; $i <= intval($credit->getInstallementCount()); $i++) {
                $installment = new Installement();
                $installment->setDebtId($credit->getId());
                $installment->setDate(\DateTime::createFromFormat('Y-m-d', $requestArr['taksit_date_' . $i]));
                $installment->setAmount(floatval($requestArr['cekilen_tutar']) / intval($requestArr['credit_installement']));
                $installment->setPrincipal(floatval($requestArr['ana_para']) / intval($requestArr['credit_installement']));
                $installment->setInstallementNo($i);
                if (array_key_exists('taksit_status_' . $i, $requestArr)) {
                    $installment->setStatus(1);
                } else {
                    $installment->setStatus(0);
                }
                $entityManager->persist($installment);
                $entityManager->flush();

            }
            return $this->redirectToRoute('app_credit');

        } catch (\Throwable $exception) {

            return $this->redirectToRoute('app_error', ['message' => $exception->getMessage()]);


        }
    }

    /**
     * @Route("/credit/get_installement_detail/", name="get_installement_detail", methods={"POST"})
     *
     */
    public function getInstallementDetail (Request $request, ManagerRegistry $managerRegistry) {

        $installementDetails  = $managerRegistry->getRepository(Installement::class)
            ->findBy(['debt_id' => $request->request->get('id')]);
        $installementDetailArr = [];
        foreach ($installementDetails as $installementDetail) {
            /**
             * @var  $installementDetail  Installement
             */
            $installementDetailArr []  = [
                'id' => $installementDetail->getId(),
                'debt_id' => $installementDetail->getDebtId(),
                'amount' => $installementDetail->getAmount(),
                'installement_no'  => $installementDetail->getInstallementNo(),
                'principal' =>$installementDetail->getPrincipal(),
                'status' => $installementDetail->getStatus(),
                'date' =>  $installementDetail->getDate()->format('d-m-Y')
            ];
        }
        return new JsonResponse(['data' => $installementDetailArr]);

    }

    /**
     * @Route("/credit/update_status/", name="update_status", methods={"POST"})
     *
     */
    public function updateInstallementStatus (Request $request, ManagerRegistry $managerRegistry) {

        $entityManager = $managerRegistry->getManager();
        $installement  = $managerRegistry->getRepository(Installement::class)
            ->findBy(['id' => $request->request->get('id')]);
        if(count($installement)>0) {

            $status = $installement[0]->getStatus();
            if($status) {
                $installement[0]->setStatus(false);
                $entityManager->flush();
            }else {
                $installement[0]->setStatus(true);
                $entityManager->flush();
            }
        }
        return new JsonResponse(['data' => []],Response::HTTP_OK);

    }
}
