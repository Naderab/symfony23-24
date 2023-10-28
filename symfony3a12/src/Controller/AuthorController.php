<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorSearchType;
use App\Form\FormAuthorType;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(Request $req,AuthorRepository $repo): Response
    {
        $authors = $repo->findAll();
        $authorsOrdred = $repo->getAuthorsOrderedByEmail();
        $form = $this->createForm(AuthorSearchType::class);
        $form->handleRequest($req);
        if($form->isSubmitted()){
            $searchText = $form->getData('input');
            $authors = $repo->getAuthorsByUsername($searchText);
            return $this->render('author/index.html.twig', [
            'authors' => $authors,
            'authorsOrdred'=>$authorsOrdred,
            'f'=>$form->createView()
        ]);
        }
        return $this->render('author/index.html.twig', [
            'authors' => $authors,
            'authorsOrdred'=>$authorsOrdred,
            'f'=>$form->createView()
        ]);
    }
    // #[Route('/author/add', name: 'app_author_add')]
    // public function addAuthor(ManagerRegistry $manager){
    //     $author = new Author();
    //     $author->setUsername('author2');
    //     $author->setEmail('author2@esprit.tn');
    //     $manager->getManager()->persist($author);
    //     $manager->getManager()->flush();
    //     return $this->redirectToRoute('app_author');
    // }

    #[Route('/author/delete/{id}', name: 'app_author_delete')]
    public function deleteAuthor(ManagerRegistry $manager,AuthorRepository $repo,$id){
        $author = $repo->find($id);
        if ($author){
            if($author->getNbBooks() == 0){

            
        $manager->getManager()->remove($author);
        $manager->getManager()->flush();
        return $this->redirectToRoute('app_author');
            }
            else {
                return new Response("Author has books!");
            }
        }
         else return new Response("There is no author with this ID!");
    }

    #[Route('/author/update/{id}', name: 'app_author_update')]
    public function updateAuthor($id,ManagerRegistry $manager,AuthorRepository $repo){
        $author = $repo->find($id);
        $author->setUsername('author updated');
        $manager->getManager()->flush();
        return $this->redirectToRoute('app_author');
    }
    #[Route('/author/add', name: 'app_author_add')]
    public function addAuthor(Request $req ,ManagerRegistry $manager){
        $author = new Author();
        $form = $this->createForm(FormAuthorType::class,$author);
        $form->handleRequest($req);
        if ($form->isSubmitted()){
            $author->setNbBooks(0);
                 $manager->getManager()->persist($author);
                 $manager->getManager()->flush();
        return $this->redirectToRoute('app_author');
        }
        return $this->render('author/add.html.twig',['a'=>$form->createView()]);

        
    }
}
