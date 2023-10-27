<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/showAuthor/{name}',name:'app_showAuthor')]
    public function showAuthor ( $name ){
        return $this->render('author/show.html.twig',[
            'n'=>$name
        ]);
    }

    #[Route('/author/get/all',name:'app_get_all_author')]
    public function getAll(AuthorRepository $repo){
        $authors = $repo->findAll();
        return $this->render('author/listauthors.html.twig',[
            'authors'=>$authors
        ]);
    }

    #[Route('/author/add',name:'app_add_author')]
    public function add(Request $req,ManagerRegistry $manager){
        $author = new Author();
        $form = $this->createForm(AuthorType::class,$author);
        $form->handleRequest($req);
        if($form->isSubmitted()){
            $author->setnb_class(0);
        $manager->getManager()->persist($author);
        $manager->getManager()->flush();
        return $this->redirectToRoute('app_get_all_author');
        }
        return $this->render('author/add.html.twig',['f'=>$form->createView()]);

    }
    #[Route('/author/delete/{id}',name:'app_delete_author')]
    public function delete($id,ManagerRegistry $manager,AuthorRepository $repo){
        $author = $repo->find($id);
        $manager->getManager()->remove($author);
        $manager->getManager()->flush();
        return $this->redirectToRoute('app_get_all_author');

    }

    #[Route('/author/update/{id}',name:'app_update_author')]
    public function update(AuthorRepository $rep,$id,Request $req,ManagerRegistry $manager){
        $author = $rep->find($id);
        $form = $this->createForm(AuthorType::class,$author);
        $form->handleRequest($req);
        if($form->isSubmitted()){
        $manager->getManager()->persist($author);
        $manager->getManager()->flush();
        return $this->redirectToRoute('app_get_all_author');
        }
        return $this->render('author/add.html.twig',['f'=>$form->createView()]);

    }
}
