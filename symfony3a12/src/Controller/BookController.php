<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\FormBookType;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(BookRepository $repo): Response
    {
        $books = $repo->findAll();
        if(!$books) {
            return new Response('No books found !');
        }
        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route('/addBook', name: 'app_book_add')]
    public function addBook(Request $request,ManagerRegistry $manager){
        $book = new Book();
        $form = $this->createForm(FormBookType::class,$book);
        $form->handleRequest($request);
        if($form->isSubmitted()){
        $author = $book->getIdAuthor();
        $author->setNbBooks($author->getNbBooks()+1);
        $book->setPublished(true);
        $manager->getManager()->persist($book);
        $manager->getManager()->flush();
        return $this->redirectToRoute('app_book');
        }
        return $this->render('book/add.html.twig',[
            'f'=>$form->createView()
        ]);
    }

    #[Route('/updateBook/{id}', name: 'app_book_update')]
    public function updateBook($id,BookRepository $repo,Request $req,ManagerRegistry $manager){
        $book =$repo->find($id);
        $form = $this->createForm(FormBookType::class,$book);
        $form->handleRequest($req);
        if($form->isSubmitted()){
        $manager->getManager()->flush();
        return $this->redirectToRoute('app_book');
        }
        return $this->render('book/add.html.twig',[
            'f'=>$form->createView()
        ]);
    }

    #[Route('/removeBook/{id}', name: 'app_book_remove')]
    public function deleteBook($id,BookRepository $repo,ManagerRegistry $manager){
        $book = $repo->find($id);
        $manager->getManager()->remove($book);
        $manager->getManager()->flush();
                return $this->redirectToRoute('app_book');

    }

    #[Route('/details/{id}', name: 'app_author_details')]
    public function getBooksByAuthor($id,BookRepository $repo){
            $books = $repo->getBooksByAuthor($id);
            return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }
}
