<?php
namespace vendor\project;

use Exception;

class FatSecretException extends Exception{
	
    public function __construct($message, $code)
    {
        parent::__construct($message, $code);
    }
}
