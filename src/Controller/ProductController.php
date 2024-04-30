<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use Psr\Log\LoggerInterface;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

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
    #[Route('/{min}/{max}', name: 'listparprix', requirements: ['min' => '\d+','max'=>'\d+'])]
    public function listparprix($min,$max,ProductRepository $productRepository): Response
    {
        $products = $productRepository->listByPriceDQL($min,$max);
        return $this->render('product/listByPrice.html.twig', [
            'products' => $products,
        ]);
    }
    #[Route('/{id}', name: 'detail',requirements: ['id' => '\d+'])]
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
    #[Route('/add/{name}/{price}/{categ}', name: 'add')]
    public function add($name,$price,$categ,EntityManagerInterface $em,LoggerInterface $logger,CategoryRepository $repoCateg): Response
    {
        $product = new Product();
        $product->setName($name);
        $product->setPrice($price);
        $category = $repoCateg->find($categ);
        $product->setCategory($category);

        $em->persist($product);
        $em->flush();
        $this->addFlash(
            'notice',
            'Produit ajoute avec succes!'
        );

        $logger->info('Un produit est ajoute avec succes ');
        return $this->redirectToRoute('app_product_list');
    }
    #[Route('/formadd', name: 'formadd')]
    public function formadd(Request $request,EntityManagerInterface $em,LoggerInterface $logger,CategoryRepository $repoCateg): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class,$product);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            //$product = $form->getData();
            $product->setCreatedAt(new \DateTime());
            $em->persist($product);
            $em->flush();
            $this->addFlash(
                'notice',
                'Produit ajoute avec succes!'
            );
            $logger->info('Un produit est ajoute avec succes ');

            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('app_product_list');
        }
        return $this->render('product/formadd.html.twig',
                    ['form'=>$form]);
    }
    #[Route('/update/{id}/{price}', name: 'update')]
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

