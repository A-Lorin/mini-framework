<?php 

namespace App\crud;

use Database\ConnectionProvider;
use ReflectionClass;
use ReflectionProperty;

class CRUD{
    
    protected $db;

    public function queryBluider($object){
        $class_name = get_class($object);
        $class = new ReflectionClass($class_name);        
        $props   = $class->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PRIVATE);        
        $partsNamespace = explode("\\",strtolower($class_name));
        $query="INSERT INTO ".end($partsNamespace)."s ";
        $columns=[];
        foreach($props as $prop){
            if($prop->getName()!="id")
                $columns[]=$prop->getName();
        }
        $query .= "(".implode(",",$columns).")";
        $query .=" VALUES ";
        $tmp = preg_replace("/^(.+)$/",":$1",$columns);
        $query .= "(".implode(",",$tmp).")";
        $stmt=$this->db->prepare($query);
        foreach($columns as $key => $column){
            $getter = "get".ucfirst($column);
            $stmt->bindValue($tmp[$key],$object->$getter());
        }  
        $stmt->execute();              
    }

    public function persist($object){        
        $this->queryBluider($object);        
    }


    public function __construct()
    {
        $this->db = ConnectionProvider::getInstance()->getConnection();
    }
}