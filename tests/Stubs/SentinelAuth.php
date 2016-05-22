<?php

namespace Humweb\PushNotify\Tests\Stubs;

/**
 * SentinelAuth
 *
 * @package Humweb\PushNotify\Tests\Stubs
 */
class SentinelAuth
{

    public function check($val = true)
    {
        return $val;
    }

    public function getUser($id = 123)
    {
        $val = new \stdClass();
        $val->id = $id;
        return $val;
    }
}