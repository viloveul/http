<?php

namespace Viloveul\Http\Contracts;

use Psr\Http\Message\ServerRequestInterface;

interface ServerRequest extends ServerRequestInterface
{
    /**
     * @param string $name
     */
    public function getPost(string $name, $default = null);

    /**
     * @param string $name
     */
    public function getQuery(string $name, $default = null);

    /**
     * @param string $name
     */
    public function getServer(string $name, $default = null);
}
