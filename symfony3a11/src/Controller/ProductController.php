<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(): Response
    {
        $title = 'Products List';
        $product = array('id'=>1,'name'=>'Phone','price'=>1000);
        $products = array (
            array('id'=>1,'name'=>'Phone','price'=>3000),
            array('id'=>2,'name'=>'Tv','price'=>4000),
            array('id'=>3,'name'=>'PC','price'=>2000)
        );
        return $this->render('product/index.html.twig', [
            'title'=>$title,
            'productObject'=>$product,
            'productsArray'=>$products
        ]);
    }
}
