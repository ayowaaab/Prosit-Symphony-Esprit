<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ProductsType;
use App\Repository\ProductsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    #[Route('/products', name: 'app_products')]
    public function products(ProductsRepository $products): Response
    {
        $l = $products->findAll();
        return $this->render('products/index.html.twig', [
            'list' => $l,
        ]);
    }

    #[Route('/addproducts', name: 'app_addproducts')]
    public function addproducts(ManagerRegistry $doctrine,Request $req): Response
    {
        $product = new Products;
        $em = $doctrine->getManager();
        $form = $this->createForm(ProductsType::class,$product);
        $form->handleRequest($req);
        if ($form->isSubmitted() and $form->isValid()){
            $em->persist($form);
            $em->flush();
            return $this->redirectToRoute("app_products");
        }
        return $this->renderForm('products/add.html.twig', [
            'f'=>$form,
        ]);
    }
}
