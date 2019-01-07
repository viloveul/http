<?php

namespace Viloveul\Http\Contracts;

interface ServerRequestAssignment
{
    /**
     * @param string     $key
     * @param $default
     */
    public function getAttribute(string $key, $default = null);

    /**
     * @param string   $key
     * @param $value
     */
    public function setAttribute(string $key, $value = null);
}
