<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ImportErrorException extends Exception
{
    protected $additionalData;

    public function __construct($message, $additionalData = [], $code = 0, Throwable $previous = null)
    {
        $this->additionalData = $additionalData;
        parent::__construct($message, $code, $previous);
    }

    public function getAdditionalData()
    {
        return $this->additionalData;
    }
}
