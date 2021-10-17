<?php

namespace Jestevezrod\Initar\Exceptions;

use Exception;

class InvalidProfileAvatarColumnException extends Exception
{

    public function __construct($message = null)
    {
        parent::__construct('The values in the user profile avatar column defined in config/initar is invalid.');
    }
}
