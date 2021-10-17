<?php

namespace Jestevezrod\Initar\Exceptions;

use Exception;

class UserColumnNameNotFoundException extends Exception
{

    public function __construct($message = null)
    {
        parent::__construct('User column name is incorrectly defined in config/initar.');
    }
}
