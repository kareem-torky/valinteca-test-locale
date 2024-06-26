<?php

namespace Valinteca\Localization\Facades;

use Illuminate\Support\Facades\Facade;

class Locale extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'locale';
    }
}