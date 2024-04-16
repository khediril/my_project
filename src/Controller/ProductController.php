<?php

namespace App\Controller;

use App\Entity\Product;
use Psr\Log\LoggerInterface;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/product', name: 'app_product_')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('product/list.html.twig', [
            'products' => $products,
        ]);
    }
    #[Route('/{id}', name: 'detail')]
    public function detail($id,ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);

        return $this->render('product/detail.html.twig', [
            'product' => $product,
        ]);
    }
    #[Route('/delete/{id}', name: 'delete')]
    public function delete($id,ProductRepository $productRepository,EntityManagerInterface $em,LoggerInterface $logger): Response
    {
        $product = $productRepository->find($id);
        $em->remove($product);
        $em->flush();
        $this->addFlash(
            'notice',
            'Produit supprime avec succes!'
        );

        $logger->info('Un produit est supprime');
        return $this->redirectToRoute('app_product_list');
    }
    #[Route('/add/{name}/{price}', name: 'app_product_delete')]
    public function add($name,$price,EntityManagerInterface $em,LoggerInterface $logger): Response
    {
        $product = new Product();
        $product->setName($name);
        $product->setPrice($price);

        $em->persist($product);
        $em->flush();
        $this->addFlash(
            'notice',
            'Produit ajoute avec succes!'
        );

        $logger->info('Un produit est ajoute avec succes ');
        return $this->redirectToRoute('app_product_list');
    }
    #[Route('/update/{id}/{price}', name: 'app_product_delete')]
    public function update($id,$price,ProductRepository $productRepository,EntityManagerInterface $em,LoggerInterface $logger): Response
    {
        $product = $productRepository->find($id);
       
       
        $product->setPrice($price);

        $em->persist($product);
        $em->flush();
        $this->addFlash(
            'notice',
            'Produit modifie avec succes!'
        );

        $logger->info('Un produit est ajoute avec succes ');
        return $this->redirectToRoute('app_product_list');
    }
}

