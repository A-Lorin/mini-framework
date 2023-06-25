<?php 

namespace Vendor\Exceptions;
use Throwable;

class NotFoundException extends AbstractException {
    // Redefine the exception so message isn't optional
    public function __construct($message="404",
     $code = 404, Throwable $previous = null) {
        // some code
        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }

    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}