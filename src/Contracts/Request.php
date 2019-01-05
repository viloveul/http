<?php

namespace Viloveul\Http\Contracts;

interface Request
{
    public static function createFromGlobals();

    /**
     * @param $key
     * @param $default
     */
    public function get($key, $default = null);

    /**
     * @param $key
     */
    public function getHeader($key);

    public function getMethod();

    public function getPathInfo();

    /**
     * @param $key
     */
    public function getServer($key);
}
