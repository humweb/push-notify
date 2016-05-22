<?php

namespace Humweb\PushNotify\Auth;

/**
 * Auth
 *
 * @package App\Humweb\PushNotify
 */
class Sentinel extends BaseAuth
{

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
        return $this->auth->getUser()->id;
    }

}