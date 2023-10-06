<?php

namespace App\Controller;

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

    #[Route('author/getall',name:'app_getall')]
    public function getAllAuthors(AuthorRepository $repo){
        $authors = $repo->findAll();
        return $this->render('author/list.html.twig',[
            'authors'=>$authors
        ]);
    }

#[Route('/author/get/{id}',name:'app_get_by_id')]
    public function getAuthorById(AuthorRepository $repo,$id){
        $author = $repo->find($id);
        return $this->render('author/details.html.twig',[
            'author'=>$author
        ]);
    }
#[Route('/author/delete/{id}',name:'app_delete_by_id')]
    public function deleteAuthor($id,ManagerRegistry $manager,AuthorRepository $repo){
        $author = $repo->find($id);
        $manager->getManager()->remove($author);
        $manager->getManager()->flush();
        return $this->redirectToRoute('app_getall');
    }
    #[Route('/author/update/{id}',name:'app_update_by_id')]
    public function updateAuthor($id,ManagerRegistry $manager,AuthorRepository $repo){
        $author = $repo->find($id);
        $author->setUsername('test update');
        $manager->getManager()->flush();
        return $this->redirectToRoute('app_getall');

    }
}
