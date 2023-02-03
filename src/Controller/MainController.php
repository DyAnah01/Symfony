<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/main', name: 'main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/', name: 'accueil')]
    public function accueil()
    {

        // $message = "Bienvenue";
        // dump($message); comme var_dump, pour tester
        // dd($message); raccourcis 
        return $this->render("main/accueil.html.twig");
    }
}
