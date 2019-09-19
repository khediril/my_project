<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestConrollerController extends AbstractController
{
    /**
     * @Route("/test/conroller", name="test_conroller")
     */
    public function index()
    {
        return $this->render('test_conroller/index.html.twig', [
            'controller_name' => 'TestConrollerController',
        ]);
    }
}
