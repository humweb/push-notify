<?php namespace Humweb\PushNotify\Facades;

use Illuminate\Support\Facades\Facade;

class PushAuth extends Facade
{

    /**
     * Get the registered name of the component
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'push.auth';
    }
}