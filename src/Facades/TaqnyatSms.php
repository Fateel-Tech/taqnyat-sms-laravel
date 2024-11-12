<?php

namespace FateelTech\TaqnyatSmsLaravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \FateelTech\TaqnyatSmsLaravel\TaqnyatSmsLaravel
 */
class TaqnyatSms extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \FateelTech\TaqnyatSmsLaravel\TaqnyatSmsLaravel::class;
    }
}
