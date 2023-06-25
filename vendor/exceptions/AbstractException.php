<?php 

namespace Vendor\Exceptions;

use Exception;
//use Helpers\ReadFile;
use Vendor\Codingx\ReadFile;
use Throwable;

class AbstractException extends Exception {

    protected $code;

    public function __construct($message,
        $code = 0, Throwable $previous = null) {
        $this->code = $code;            
        parent::__construct($message, $code, $previous);
    }

    public function load(){
        $errors  = ReadFile::readJson(BASE_DIR."config/errors.json");
        ob_start();
        require_once $errors["error_page"]["{$this->code}"];
        $html = ob_get_contents();
        ob_clean();
        return $html;
    }

}