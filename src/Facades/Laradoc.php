<?php

namespace Victoranw\Laradoc\Facades;

use Illuminate\Support\Facades\Facade;

class Laradoc extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laradoc';
    }
}
