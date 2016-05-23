<?php

namespace Humweb\PushNotify\Tests;

use Humweb\PushNotify\Auth;
use Humweb\PushNotify\Auth\BaseAuth;
use Humweb\PushNotify\Auth\Sentinel;
use Humweb\PushNotify\Tests\Stubs\SentinelAuth;

class AuthManagerTest extends TestCase
{

    protected $manager;


    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();

        $this->manager = new Auth($this->app);
    }


    /**
     * @test
     */
    public function it_creates_laravel_driver()
    {
        $auth = $this->manager->driver('laravel');
        $this->assertTrue($auth instanceof BaseAuth);

    }

    /**
     * @test
     */
    public function it_sets_and_gets_default_driver()
    {
        $this->manager->setDefaultDriver('laravel');
        $auth = $this->manager->driver();

        $this->assertEquals('laravel', $this->manager->getDefaultDriver());
        $this->assertTrue($auth instanceof BaseAuth);

    }


    /**
     * @test
     */
    public function it_creates_sentinel_driver()
    {
        $this->app->singleton('sentinel', function () {
            return new SentinelAuth();
        });

        $auth = $this->manager->driver('sentinel');
        $this->assertTrue($auth instanceof Sentinel);
    }

}
