<?php

namespace Beesperester\Resource\Exceptions;

// laravel
use Illuminate\Contracts\Validation\Validator;

// facades
use Exception;

class ValidationException extends Exception
{
    /**
    * The validator instance.
    *
    * @param \Illuminate\Contracts\Validation\Validator
    */
    public $validator;

    /**
    * The recommended messages to send to the client.
    *
    * @param \Symfony\Component\HttpFoundation\Response|null
    */
    public $messages;

    /**
    * Create a new exception instance.
    *
    * @param Validator $validator
    * @param Array $messages
    * @return void
    */
    public function __construct(Validator $validator, Array $messages = []) {
        parent::__construct('The given data failed to pass validation.');

        $this->messages = $messages;
        $this->validator = $validator;
    }

    /**
    * Get the messages.
    *
    * @return Array
    */
    public function getMessages() {
        return $this->messages;
    }
}
