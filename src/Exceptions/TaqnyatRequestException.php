<?php

namespace FateelTech\TaqnyatSmsLaravel\Exceptions;

use Exception;

class TaqnyatRequestException extends Exception
{
    public static function unAuthorized(): self
    {
        return new static('invalid credentials information', 401);
    }

    public static function unknownError($message, $code): self
    {
        return new static($message, $code);
    }
}
