<?php

namespace Humweb\PushNotify\Tests;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return ['Humweb\PushNotify\PushServiceProvider'];
    }

    protected function getPackageAliases($app)
    {
        return [
            'PushAuth' => 'Humweb\PushNotify\Facades\PushAuth'
        ];
    }
}
