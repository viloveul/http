<?php

namespace Viloveul\Http\Contracts;

use Psr\Http\Message\ServerRequestInterface;

interface ServerRequest extends ServerRequestInterface
{
    /**
     * @param string $name
     */
    public function getServer(string $name);
}
