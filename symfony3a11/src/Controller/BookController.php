<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/addBook', name: 'app_book_add')]
    public function addBook(Request $req,ManagerRegistry $manager) {
        $book = new Book();
        $form = $this->createForm(BookType::class,$book);
        $form->handleRequest($req);
        //$book->setRef($form->getData()->getRef());
        if($form->isSubmitted()){
            $book->setPublished(true);
        $manager->getManager()->persist($book);
        $manager->getManager()->flush();
        return $this->redirectToRoute('app_book');
        }
        return $this->render('book/add.html.twig',[
            'f'=>$form->createView()
        ]);
    }
}
