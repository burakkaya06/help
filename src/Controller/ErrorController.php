<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    /**
     * @Route("/error/{message}", name="app_error")
     */
    public function index($message): Response
    {
        return $this->render('error/index.html.twig', [
            'message' => $message,
        ]);
    }
}
