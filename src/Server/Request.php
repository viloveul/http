<?php

namespace Viloveul\Http\Server;

use Viloveul\Http\Contracts\ServerRequest as IServerRequest;
use Zend\Diactoros\ServerRequest;

class Request extends ServerRequest implements IServerRequest
{
    /**
     * @param  string     $name
     * @param  $default
     * @return mixed
     */
    public function getPost(string $name, $default = null)
    {
        $name = strtolower($name);
        $params = $this->getParsedBody();
        if (array_key_exists($name, $params)) {
            return $params[$name];
        }
        return $default;
    }

    /**
     * @param  string     $name
     * @param  $default
     * @return mixed
     */
    public function getQuery(string $name, $default = null)
    {
        $name = strtolower($name);
        $params = $this->getQueryParams();
        if (array_key_exists($name, $params)) {
            return $params[$name];
        }
        return $default;
    }

    /**
     * @param  string  $name
     * @return mixed
     */
    public function getServer(string $name, $default = null)
    {
        $name = strtolower($name);
        $params = $this->getServerParams();
        if (array_key_exists($name, $params)) {
            return $params[$name];
        }
        return $default;
    }
}
