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

    #[Route('/showTeacherTwig',name:'show_teacher_twig')]
    public function showTWIG(){
        $title = 'List of teachers';
        $teachers = array(
            array('id'=>1,'name'=>'Teacher 1','nb_class'=>4),
            array('id'=>2,'name'=>'Teacher 2','nb_class'=>7),
            array('id'=>3,'name'=>'Teacher 3','nb_class'=>6),

        );
        return $this->render('teacher/show.html.twig',['t'=>$title,'tt'=>$teachers]);
    }
}
