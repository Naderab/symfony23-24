<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    #[Route('/teacher', name: 'app_teacher')]
    public function index(): Response
    {
        return new Response("Bonjour");
    }

    #[Route('/showteacher/{name}/{id}',name:'app_showteacher')]
    public function showTeacher($name,$id){
        return new Response("Bonjour ". $name.' '.$id);
    }
    
}
