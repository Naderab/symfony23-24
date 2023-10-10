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
    public function index(AuthorRepository $repo): Response
    {
        $authors = $repo->findAll();
        return $this->render('author/index.html.twig', [
            'authors' => $authors,
        ]);
    }
    #[Route('/author/add', name: 'app_author_add')]
    public function addAuthor(ManagerRegistry $manager){
        $author = new Author();
        $author->setUsername('author2');
        $author->setEmail('author2@esprit.tn');
        $manager->getManager()->persist($author);
        $manager->getManager()->flush();
        return $this->redirectToRoute('app_author');
    }

    #[Route('/author/delete/{id}', name: 'app_author_delete')]
    public function deleteAuthor(ManagerRegistry $manager,AuthorRepository $repo,$id){
        $author = $repo->find($id);
        $manager->getManager()->remove($author);
        $manager->getManager()->flush();
        return $this->redirectToRoute('app_author');
    }

    #[Route('/author/update/{id}', name: 'app_author_update')]
    public function updateAuthor($id,ManagerRegistry $manager,AuthorRepository $repo){
        $author = $repo->find($id);
        $author->setUsername('author updated');
        $manager->getManager()->flush();
        return $this->redirectToRoute('app_author');
    }
}
