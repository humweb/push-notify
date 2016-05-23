<?php

namespace Humweb\PushNotify\Tests;

use Humweb\PushNotify\Auth\BaseAuth;
use Humweb\PushNotify\Auth\Sentinel;
use Humweb\PushNotify\PrivateChannel;
use Humweb\PushNotify\Tests\Stubs\LaravelAuth;
use Humweb\PushNotify\Tests\Stubs\SentinelAuth;
use InvalidArgumentException;
use Mockery as m;
use Pusher;

class PrivateChannelTest extends TestCase
{

    protected $laravel;
    protected $sentinel;
    protected $internal;


    public function tearDown()
    {
        parent::tearDown();
        m::close();
    }


    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();
        $this->laravel  = new PrivateChannel(new BaseAuth(new LaravelAuth()));
        $this->sentinel = new PrivateChannel(new Sentinel(new SentinelAuth()));
        $this->internal = PrivateChannel::forUser(33);
    }


    /**
     * @test
     */
    public function it_authenticates_sockets()
    {
        $pusher = m::mock('Pusher');
        $pusher->shouldReceive('socket_auth')->withArgs([$this->laravel->getChannel(), 123])->andReturn(true);
        $this->laravel->setPusher($pusher);
        $this->assertTrue($this->laravel->auth('private-notifications-123', 123));
    }


    /**
     * @test
     */
    public function it_authenticates_internal_user_sockets()
    {
        $pusher = m::mock('Pusher');
        $pusher->shouldReceive('socket_auth')->withArgs([$this->internal->getChannel(), 33])->andReturn(true);
        $this->internal->setPusher($pusher);
        $this->assertTrue($this->internal->auth('private-notifications-33', 33));
    }


    /**
     * @test
     */
    public function it_fails_to_authenticate_unauthorized_sockets()
    {
        $pusher = m::mock('Pusher');
        $pusher->shouldReceive('socket_auth')->withArgs([$this->laravel->getChannel(), 321])->andReturn(false);
        $this->laravel->setPusher($pusher);
        $this->assertFalse($this->laravel->auth('private-notifications-321', 321));
    }


    /**
     * @test
     */
    public function it_authenticates_presence_auth()
    {
        $pusher = m::mock('Pusher');
        $pusher->shouldReceive('presence_auth')->withArgs([$this->laravel->getChannel(), 321, 123, ['first_name' => 'john']])->andReturn(true);
        $this->laravel->setPusher($pusher);
        $this->assertTrue($this->laravel->presenceAuth('private-notifications-123', 321, ['first_name' => 'john']));
    }


    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function it_throws_exception_when_no_data_passed_to_presence_auth()
    {
        $pusher = m::mock('Pusher');
        $pusher->shouldReceive('presence_auth')->withArgs([$this->laravel->getChannel(), 321])->andReturn(false);
        $this->laravel->setPusher($pusher);
        $this->assertFalse($this->laravel->presenceAuth('private-notifications-321', 321));
    }

}
