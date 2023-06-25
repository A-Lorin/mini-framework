<?php 

namespace Vendor\Codingx;

class Request{

    private $request = [];

    public function __construct()
    {
        $this->request = array_merge($_GET,$_POST,$_COOKIE,$_FILES,$_SERVER);
    }

    public function get($key){
        return (isset($this->request[$key]))?$this->request[$key]:false;
    }

}