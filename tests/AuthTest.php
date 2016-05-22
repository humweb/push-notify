<?php

namespace Humweb\PushNotify\Tests;

use Humweb\PushNotify\Auth\BaseAuth;
use Humweb\PushNotify\Auth\Sentinel;
use Humweb\PushNotify\Tests\Stubs\LaravelAuth;
use Humweb\PushNotify\Tests\Stubs\SentinelAuth;

class AuthTest extends TestCase
{
    
    protected $laravel;
    protected $sentinel;
    
    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();

        $this->laravel = new BaseAuth(new LaravelAuth());
        $this->sentinel = new Sentinel(new SentinelAuth());
    }
    
    /**
     * @test
     */
    public function it_checks_auth()
    {
        $this->assertEquals(true, $this->laravel->check());
        $this->assertEquals(true, $this->sentinel->check());
    }  

    /**
     * @test
     */
    public function it_gets_user_id()
    {
        $this->assertEquals(123, $this->laravel->userId());
        $this->assertEquals(123, $this->sentinel->userId());
    }  
    
    /**
     * @test
     */
    public function it_returns_users_id()
    {
        $this->assertEquals(123, $this->laravel->userId());
        $this->assertEquals(123, $this->sentinel->userId());

        $this->assertEquals(true, $this->laravel->check());
        $this->assertEquals(true, $this->sentinel->check());
    }
}
