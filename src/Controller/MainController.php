<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/main', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/page2', name: 'app_page2')]
    public function page2(): Response
    {
        $tab=["Ali","Salah","Sami","ahlem","Chahd","Chaima"];
        return $this->render('main/index.html.twig', [
            "tab" => $tab
        ]);
    }
    #[Route('/page3/{id}', name: 'app_page3')]
    public function page3($id): Response
    {
        
        return $this->render('main/page3.html.twig', [
            "id" => $id
        ]);
    }
}
