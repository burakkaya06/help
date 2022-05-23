<?php

namespace App\Controller;

use App\Entity\CreditCard;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreditCardController extends AbstractController
{
    /**
     * @Route("/credit/card", name="app_credit_card")
     */
    public function index(ManagerRegistry $managerRegistry): Response
    {

        $creditCardsArr = [];

        $sql = "
        select *
        from credit_card
        left join user on credit_card.card_holder = user.id;
    ";

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        $creditCards = $stmt->fetchAll();

        $users = $managerRegistry->getRepository(User::class)->findAll();
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
        $totalBorc = 0;
        $usefulLimit = 0;
        foreach ($creditCards as $card) {

            $splitCreditCardNo = str_split($card['card_no'],4);
            $cardNo = "";
            foreach ($splitCreditCardNo as $no) {
                $cardNo.=' '.$no;
            }
            $creditCardsArr [] = [
                'id' => $card['id'],
                'bank_info' => $card['bank_info'],
                'card_holder' => $card['name_surnama'],
                'card_no' => $cardNo,
                'card_limit' => $card['card_limit'],
                'card_klimit' => $card['useful_limit'],
                'credit_card_debt' => $card['card_limit'] - $card['useful_limit'],
                'url' => $card['card_image_url']
            ];
            $totalBorc+=$card['card_limit'] - $card['useful_limit'];
            $usefulLimit+=$card['useful_limit'];
        }

        return $this->render('credit_card/index.html.twig', [
            'creditCards' => $creditCardsArr,
            'users' => $userArr,
            'totalBorc' => $totalBorc,
            'usefulLimit' => $usefulLimit
        ]);
    }


    /**
     * @Route("/credit/save", name="app_credit_card_save", methods={"POST"})
     *
     */
    public function saveCard(Request $request, ManagerRegistry $doctrine) : Response
    {
        try {
            $entityManager = $doctrine->getManager();
            $card = new CreditCard();
            $card->setCardHolder($request->request->get("card_name"));
            $card->setBankInfo($request->request->get("bank_info"));
            $card->setCardNo($request->request->get("card_number"));
            $card->setCardLimit($request->request->get("limit"));
            $card->setUsefulLimit($request->request->get("klimit"));
            $card->setCardImageUrl($request->request->get("kurl"));
            $card->setDebtType(1);
            //$card->setCreatedAt(date('Y-m-d H:i:s'));
            $entityManager->persist($card);
            $entityManager->flush();

        } catch (\Exception $exception) {


        }
        return new Response('Saved new product with id '.$card->getId());
    }
}
