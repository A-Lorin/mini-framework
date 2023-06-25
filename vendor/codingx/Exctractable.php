<?php 

namespace Vendor\Codingx;

trait Exctractable{

    public function getTagContent(&$html,$tag="extends"){
        $patternCSS = "/<$tag>(.*)<\/$tag>/ms";
        $flag = preg_match($patternCSS,$html,$matches);
        if($flag){
            $html=preg_replace($patternCSS,"",$html);
            return $matches[1];
        } else{
            return false;
        }       
    }           
}