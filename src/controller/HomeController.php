<?php 

namespace App\Controller;

use App\Annotation\Route;
use App\Controller\AbstractController;

class HomeController extends AbstractController{
    #[Route("/")]
    public function index(){ 
        $title = "Accueil";
        return $this->renderView("home/index",[
            "title"=>$title
        ],"Accueil");        
    }

}