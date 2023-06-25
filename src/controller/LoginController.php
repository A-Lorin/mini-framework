<?php 
namespace App\Controller;

use App\Annotation\Route;
use App\crud\CRUDFactory;
use root\Session;
use Vendor\Codingx\Validator;
#[Route("/login")]
class LoginController extends AbstractController{

    #[Route("/")]
    public function login($request){ 
                
        if( isset($request["email"]) &&
            isset($request["password"]) ){
                $email = Validator::checkEmail($request["email"]);
                $password = Validator::checkPassword($request["password"]);
                $user = CRUDFactory::getUserCRUD()->selectByEmail($email);           
                if(password_verify($password,$user->getPassword())){
                    $user->setPassword(":p");
                    $this->session()->set("user",$user);
                    // redirect
                    $this->redirect("dashboard");
                }
            }
        return $this->renderView("login/index");
    }

}