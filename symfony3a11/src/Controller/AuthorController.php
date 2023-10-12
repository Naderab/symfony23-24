<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
            'a'=>$authors
        ]);
    }

    #[Route('/author/add',name:'app_add_author')]
    public function add(ManagerRegistry $manager){

        $author = new Author();
        $author->setUsername('author 1');
        $author->setEmail('author1@esprit.tn');
        $manager->getManager()->persist($author);
        $manager->getManager()->flush();
        return $this->redirectToRoute('app_get_all_author');

    }
    #[Route('/author/delete/{id}',name:'app_delete_author')]
    public function delete($id,ManagerRegistry $manager,AuthorRepository $repo){
        $author = $repo->find($id);
        $manager->getManager()->remove($author);
        $manager->getManager()->flush();
        return $this->redirectToRoute('app_get_all_author');

    }
}
