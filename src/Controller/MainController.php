<?php

namespace App\Controller;

use Doctrine\DBAL\Types\JsonType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/main', name: 'app_main_')]
class MainController extends AbstractController
{
    #[Route('/main', name: 'main')]
    public function index(): Response
    {
        $tab=["Ali","Salah","Sami","ahlem","Chahd","Chaima"];
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController', "tab" => $tab
        ]);
    }
    #[Route('/page2', name: 'page2')]
    public function page2(): Response
    {
        $tab=["Ali","Salah","Sami","ahlem","Chahd","Chaima"];
        return $this->render('main/index.html.twig', [
            "tab" => $tab
        ]);
    }
    #[Route('/page3/{id}', name: 'page3')]
    public function page3($id): Response
    {
        
        return $this->render('main/page3.html.twig', [
            "id" => $id
        ]);
    }
    
    #[Route('/api', name: 'api')]
    public function api(): JsonResponse
    {
        $response = new JsonResponse(['nom' => 'Ben foulen','prenom' => 'foulen']);
        return $response;
        
    }
    #[Route('/test', name: 'test')]
    public function test(): Response
    {
        return $this->render('main/test.html.twig');
    }
    


}
