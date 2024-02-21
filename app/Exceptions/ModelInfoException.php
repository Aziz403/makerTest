<?php 

namespace App\Exceptions;

class ModelInfoException extends \Exception
{
    public function __construct($message = null)
    {
        parent::__construct($message);
    }
}