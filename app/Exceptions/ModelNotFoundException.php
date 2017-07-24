<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ModelNotFoundException extends Exception
{

    public $error = 'not_found';

    public function __construct($message = "", $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getError() {
        return $this->error;
    }

}