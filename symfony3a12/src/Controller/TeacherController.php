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

    #[Route('/show',name:'app_show')]
    public function show(){
        $title = "Teacher";
        $teachers = array (
            array('id'=>1,'name'=>'test','salaire'=>1000),
            array('id'=>2,'name'=>'teacher2','salaire'=>2000),
            array('id'=>3,'name'=>'test','salaire'=>3000)
        );
        return $this->render('teacher/show.html.twig',['t'=>$title,'tt'=>$teachers]);
    }

    #[Route('/details/{id}',name:'app_details')]
    public function details($id){
        return $this->render('teacher/details.html.twig',['id'=>$id]);
    }
    
}
