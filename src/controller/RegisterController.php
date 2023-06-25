<?php 
namespace App\Controller;

use App\Annotation\Route;
use App\crud\CRUDFactory;
use App\Model\User;
use Exception;
use Vendor\Codingx\Validator;
#[Route("/register")]
class RegisterController extends AbstractController{
    #[Route("/")]
    public function addUser($request){
        $error = "";
        if(
            isset($request["prenom"]) &&
            isset($request["nom"]) &&
            isset($request["email"]) &&
            isset($request["password"])
            ){
                try{                    
                    // validate fields
                    $nom = Validator::filterString($request["nom"],"Nom");
                    $prenom = Validator::filterString($request["prenom"],"Prenom");
                    $email = Validator::checkEmail($request["email"]);
                    $password = Validator::checkPassword($request["password"]);
                    // create user object
                    $user = new User;
                    $user->setPrenom($prenom)
                         ->setNom($nom)   
                         ->setEmail($email)
                         ->setPassword(password_hash($password,PASSWORD_DEFAULT))
                         ->setIp(password_hash($_SERVER['REMOTE_ADDR'],PASSWORD_DEFAULT))
                         ->setUserAgent(password_hash($_SERVER['HTTP_USER_AGENT'],PASSWORD_DEFAULT));
                    // insert user
                    CRUDFactory::getUserCRUD()->insert($user);
                    // redirect to login
                    $this->redirect("login");
                }catch(Exception $e){
                    $error = $e->getMessage();
                }

            }

        return $this->renderView("register/index",compact("error"));
    }


}