<?php

namespace Humweb\PushNotify;

use Humweb\PushNotify\Auth\AuthUserContract;
use Humweb\PushNotify\Auth\InternalAuth;

/**
 * PrivateChannel
 *
 * @package Humweb\PushNotify
 */
class PrivateChannel
{

    /**
     * @var string
     */
    protected $prefix = 'private-notifications-';

    /**
     * @var \Humweb\PushNotify\Auth\AuthUserContract
     */
    protected $user;

    /**
     * @var \Pusher
     */
    protected $pusher;


    /**
     * PrivateChannel constructor.
     *
     * @param      $user
     * @param null $prefix
     */
    public function __construct(AuthUserContract $user, $prefix = null)
    {
        $this->pusher = app()->offsetExists('pusher') ? app('pusher') : null;

        $this->user = $user;

        if ($prefix) {
            $this->prefix = $prefix;
        }
    }


    /**
     * Fire event
     *
     * @param       $event
     * @param array $payload
     *
     * @return bool|string
     */
    public function fire($event, $payload = [])
    {
        return $this->pusher->trigger([$this->getChannel()], $event, $payload);
    }


    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }


    /**
     * @param string $prefix
     *
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }


    /**
     * Get channel
     *
     * @return string
     */
    public function getChannel()
    {
        return $this->prefix.$this->user->userId();
    }


    /**
     * Authenticate pusher socket
     *
     * @param $channel
     * @param $socketId
     *
     * @return string|false
     */
    public function auth($channel, $socketId)
    {
        return $this->presenceOrSocketAuth($channel, $socketId);
    }


    /**
     * Authenticate pusher presence
     *
     * @param       $channel
     * @param       $socketId
     * @param array $presenceData
     *
     * @throws \InvalidArgumentException
     *
     * @return string|false
     */
    public function presenceAuth($channel, $socketId, $presenceData = [])
    {
        if (empty($presenceData)) {
            throw new \InvalidArgumentException('Missing presence data.');
        }

        return $this->presenceOrSocketAuth($channel, $socketId, $presenceData);
    }


    /**
     * Authenticate pusher socket or presence
     *
     * @param       $channel
     * @param       $socketId
     * @param array $presenceData
     *
     * @return string|false
     */
    public function presenceOrSocketAuth($channel, $socketId, $presenceData = [])
    {

        if ($this->user->check() && $this->getChannel() == $channel) {
            if (empty($presenceData)) {
                return $this->pusher->socket_auth($this->getChannel(), $socketId);
            } else {
                return $this->pusher->presence_auth($this->getChannel(), $socketId, $this->user->userId(), $presenceData);
            }
        } else {
            return false;
        }
    }


    public static function forUser($userId)
    {
        return new static(new InternalAuth($userId));
    }


    /**
     * @return \Pusher
     */
    public function getPusher()
    {
        return $this->pusher;
    }


    /**
     * @param \Pusher $pusher
     */
    public function setPusher($pusher)
    {
        $this->pusher = $pusher;
    }
}