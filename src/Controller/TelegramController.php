<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TelegramController extends AbstractController
{
    /**
     * @Route("/telegram", name="app_telegram")
     */
    public function index(): Response
    {
        return $this->render('telegram/index.html.twig', [
            'controller_name' => 'TelegramController',
        ]);
    }
}
