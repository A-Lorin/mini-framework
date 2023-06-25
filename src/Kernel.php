<?php 
namespace App;
use Config\Router;
use Exception;
use Vendor\Codingx\LoadConfig;
use Vendor\Exceptions\AbstractException;

class Kernel{

    public static function prod(){

    }

    public static function dev(){
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");       
    }

    public static function boot(){
        // load config
        LoadConfig::load();
        try{
            $env = ENV;
            static::$env();
            $datas = Router::route();
            extract($datas);
            $layoutFile = "src/view/$layout.php";
            if(file_exists($layoutFile)){
                require_once "src/view/$layout.php";
            }else{
                throw new Exception("Layout not defined <extends>?</extends>");
            }
        }catch(AbstractException $e){          
            echo $e->load();
        }
    }

}