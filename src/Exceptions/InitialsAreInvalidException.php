<?php

namespace Jestevezrod\Initar\Exceptions;

use Exception;

class InitialsAreInvalidException extends Exception
{

    public function __construct($message = null)
    {
        parent::__construct('The values in the user column name defined in config/initar are retrieving invalid values.');
    }
}
