<?php

namespace Prettus\TinyERP\Exceptions;

class ValidationException extends TinyException
{
    public function __construct(array $errors)
    {
        $message = implode("\n", $errors);
        parent::__construct($message);
    }
}