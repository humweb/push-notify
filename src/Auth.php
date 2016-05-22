<?php

namespace Humweb\PushNotify;

use Humweb\PushNotify\Auth\BaseAuth;
use Humweb\PushNotify\Auth\Sentinel;
use Illuminate\Support\Manager;

/**
 * Auth
 *
 * @package App\Humweb\PushNotify\Auth
 */
class Auth extends Manager
{

    protected function createLaravelDriver()
    {
        return new BaseAuth($this->app['auth']);
    }


    protected function createSentinelDriver()
    {
        return new Sentinel($this->app['sentinel']);
    }


    /**
     * Get the default cache driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['pusher.auth'];
    }


    /**
     * Set the default cache driver name.
     *
     * @param  string $name
     *
     * @return void
     */
    public function setDefaultDriver($name)
    {
        $this->app['config']['pusher.auth'] = $name;
    }

}