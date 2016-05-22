<?php

namespace Humweb\PushNotify\Auth;

/**
 * AuthUser
 *
 * @package Humweb\PushNotify\Auth
 */
interface AuthUserContract
{

    /**
     * Check if user is authenticated
     *
     * @return bool
     */
    public function check();


    /**
     * Get user id
     *
     * @return integer
     */
    public function userId();

}