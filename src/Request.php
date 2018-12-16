<?php

namespace Viloveul\Http;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Viloveul\Http\Contracts\Request as IRequest;

class Request extends SymfonyRequest implements IRequest
{
    /**
     * @param  $key
     * @return mixed
     */
    public function getHeader($key)
    {
        return $this->headers->get($key);
    }

    /**
     * @param  $key
     * @return mixed
     */
    public function getServer($key)
    {
        return $this->server->get($key);
    }
}
