<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
   #[Route('/book/get/all',name:'app_get_all_book')]
    public function getAll(BookRepository $repo){
        $books = $repo->findAll();
        return $this->render('book/index.html.twig',[
            'books'=>$books
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
        $author = $book->getAuthor();
        $author->setnb_class($author->getnb_class()+1);
        $manager->getManager()->persist($book);
        $manager->getManager()->flush();
        return $this->redirectToRoute('app_book');
        }
        return $this->render('book/add.html.twig',[
            'f'=>$form->createView()
        ]);
    }
    #[Route('/book/delete/{id}',name:'app_delete_book')]
    public function delete($id,ManagerRegistry $manager,BookRepository $repo){
        $book = $repo->find($id);
        $manager->getManager()->remove($book);
        $manager->getManager()->flush();
        return $this->redirectToRoute('app_get_all_book');

    }


    #[Route('/book/update/{ref}',name:'app_update_book')]
    public function update(BookRepository $rep,$ref,Request $req,ManagerRegistry $manager){
        $book = $rep->find($ref);
        $form = $this->createForm(BookType::class,$book);
        $form->handleRequest($req);
        if($form->isSubmitted()){
        $manager->getManager()->persist($book);
        $manager->getManager()->flush();
        return $this->redirectToRoute('app_get_all_book');
        }
        return $this->render('book/add.html.twig',['f'=>$form->createView()]);

    }

}
