<?php 
namespace Vendor\Codingx;

class LoadConfig{


    public static function load(){
        $configs=ReadFile::readJson("config/config.json");
        foreach($configs as $key => $value ){
            define($key,$value);            
        }
    }


}
