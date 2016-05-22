<?php

namespace Humweb\PushNotify\Auth;

/**
 * Class InternalAuth
 *
 * @package Humweb\PushNotify\Auth
 */
class InternalAuth implements AuthUserContract
{

    /**
     * InternalAuth constructor.
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }


    /**
     * Factory create
     *
     * @param $userId
     *
     * @return static
     */
    public static function create($userId)
    {
        return new static($userId);
    }


    /**
     * Check if user is authenticated
     *
     * @return bool
     */
    public function check()
    {
        return true;
    }


    /**
     * Get user id
     *
     * @return integer
     */
    public function userId()
    {
        return $this->userId;
    }

}