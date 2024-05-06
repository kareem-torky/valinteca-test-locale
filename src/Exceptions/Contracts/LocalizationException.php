<?php

namespace Valinteca\Localization\Exceptions\Contracts;

use Exception;

abstract class LocalizationException extends Exception
{
    /**
     * @param $e
     */
    public function __construct(private string $e = '')
    {
        $this->message = $e;
    }
}