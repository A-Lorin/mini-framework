<?php 
namespace App\Controller;


#[Route("/dashboard")]
class DashboardController extends AbstractController{
    #[Route("/")]
    public function index(){
        $user = $this->session()->get("user");
        return $this->renderView("dashboard/index",
        compact("user"),"Mon compte");
    }

}
