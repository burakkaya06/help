<?php

namespace App\Controller;

use App\Entity\DebtType;
use App\Entity\Expense;
use App\Entity\ExpenseParent;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SettingsController extends AbstractController
{
    /**
     * @Route("/settings", name="app_settings")
     */
    public function index(): Response
    {
        return $this->render('settings/index.html.twig', [
            'controller_name' => 'SettingsController',
        ]);
    }

    /**
     * @Route("/user/index", name="user_index")
     */
    public function userIndex(): Response
    {
        return $this->render('settings/user/user.html.twig');
    }

    /**
     * @Route("/borcturu/index", name="borcturu_index")
     */
    public function borcTuruIndex(): Response
    {
        return $this->render('settings/borcturu/borcturu.html.twig');
    }

    /**
     * @Route("/gider/index", name="gider_index")
     */
    public function giderIndex(ManagerRegistry $managerRegistry): Response
    {
        $expenseParentArr =[];
        $expenseParents = $managerRegistry->getRepository(ExpenseParent::class)->findAll();
        foreach ($expenseParents as $expenseParent) {
            /**
             * @var $expenseParent ExpenseParent
             */
            $expenseParentArr [] =
                [
                    'id' => $expenseParent->getId(),
                    'name' => $expenseParent->getName(),
                ];
        }
        return $this->render('settings/gider/gider.html.twig',  ['expenseParent' => $expenseParentArr]);
    }

    /**
     * @Route("/settings/save_user", name="app_save_user", methods={"POST"})
     *
     */
    public function saveUser(Request $request, ManagerRegistry $doctrine) : Response
    {
        try {
            $entityManager = $doctrine->getManager();
            $user = new User();
            $user->setNameSurnama($request->request->get("user_name"));
            $user->setActive(1);
            $entityManager->persist($user);
            $entityManager->flush();
            return new Response('Saved new product with id '.$user->getId());

        } catch (\Exception $exception) {


        }
    }

    /**
     * @Route("/settings/save_borc", name="save_borc", methods={"POST"})
     *
     */
    public function saveBorc(Request $request, ManagerRegistry $doctrine) : Response
    {
        try {
            $entityManager = $doctrine->getManager();
            $debt = new DebtType();
            $debt->setName($request->request->get("borc_type"));
            $entityManager->persist($debt);
            $entityManager->flush();
            return new Response('Saved new product with id '.$debt->getId());

        } catch (\Exception $exception) {


        }
    }

    /**
     * @Route("/settings/gider", name="save_gider", methods={"POST"})
     *
     */
    public function saveGider(Request $request, ManagerRegistry $doctrine) : Response
    {
        try {
            $entityManager = $doctrine->getManager();
            $gider = new Expense();
            $gider->setName($request->request->get("gider_name"));
            $gider->setParentId($request->request->get("gider_turu"));
            $entityManager->persist($gider);
            $entityManager->flush();
            return new Response('Saved new product with id '.$gider->getId());

        } catch (\Exception $exception) {


        }
    }

    /**
     * @Route("/settings/gider_parent", name="save_gider_parent", methods={"POST"})
     *
     */
    public function saveGiderParent(Request $request, ManagerRegistry $doctrine) : Response
    {
        try {
            $entityManager = $doctrine->getManager();
            $giderParent = new ExpenseParent();
            $giderParent->setName($request->request->get("gider_parent_name"));
            $entityManager->persist($giderParent);
            $entityManager->flush();
           return $this->redirectToRoute('gider_index');

        } catch (\Throwable $exception) {

            return $this->redirectToRoute('app_error',['message' => $exception->getMessage()]);


        }
    }
}
