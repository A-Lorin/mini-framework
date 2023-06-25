<?php 
namespace Vendor\Codingx;

trait Redirect{

    protected function redirect($link){
        header("Location:".CONTEXT_PATH."$link");
        exit();
    }

}