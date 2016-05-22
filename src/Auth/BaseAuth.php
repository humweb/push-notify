<?php

namespace Humweb\PushNotify\Auth;

/**
 * Class BaseAuth
 *
 * @package Humweb\PushNotify\Auth
 */
class BaseAuth implements AuthUserContract
{

    protected $user;


    /**
     * Auth constructor.
     */
    public function __construct($auth)
    {

        $this->auth = $auth;
    }


    /**
     * Check if user is authenticated
     *
     * @return bool
     */
    public function check()
    {
        return $this->auth->check();
    }


    /**
     * Get user id
     *
     * @return integer
     */
    public function userId()
    {
        return $this->auth->user()->id;
    }

}