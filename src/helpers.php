<?php

namespace Valinteca\Localization;

if (! function_exists('locale')) {
    function locale(): Locale
    {
        app()->singletonIf(Locale::class);

        return app(Locale::class);
    }
} else {
    throw new \Exception("Function locale name conflict");
}
