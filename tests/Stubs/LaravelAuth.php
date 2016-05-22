<?php

namespace Humweb\PushNotify\Tests\Stubs;

/**
 * LaravelAuth
 *
 * @package Humweb\PushNotify\Tests\Stubs
 */
class LaravelAuth
{

    public function check($val = true)
    {
        return $val;
    }

    public function user($id = 123)
    {
        $val = new \stdClass();
        $val->id = $id;
        return $val;
    }
}