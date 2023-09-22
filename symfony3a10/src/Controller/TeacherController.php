<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    // #[Route('/teacher', name: 'app_teacher')]
    public function index(): Response
    {
        return new Response("Bonjour");
    }

    public function showTeacher(){
        return new Response("show Teacher");
    }

    #[Route('/showTeacher/{name}',name:'show_teacher')]
    public function showTeacherWithName($name){
        return new Response ('Bonjour '.$name);
    }
}
