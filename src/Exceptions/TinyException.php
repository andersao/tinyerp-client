<?php

namespace Prettus\TinyERP\Exceptions;

class TinyException extends \Exception
{
    protected ?array $errors = [];

    public function getErrors(): ?array
    {
        return $this->errors;
    }

    public function setErrors(?array $errors): void
    {
        $this->errors = $errors;
    }
}