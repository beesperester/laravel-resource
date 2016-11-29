<?php

namespace Beesperester\Resource\Exceptions;

use Exception;

class DeprecatedException extends Exception
{
    /**
    * Create a new exception instance.
    *
    * @return void
    */
    public function __construct() {
        parent::__construct('This Method is deprecated.');
    }
}
