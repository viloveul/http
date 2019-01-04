<?php

namespace Viloveul\Http\Server;

use Viloveul\Http\Contracts\ServerRequest as IServerRequest;
use Zend\Diactoros\ServerRequest;

class Request extends ServerRequest implements IServerRequest
{
    /**
     * @param  string  $name
     * @return mixed
     */
    public function getServer(string $name)
    {
        $name = strtolower($name);
        $params = $this->getServerParams();
        if (array_key_exists($name, $params)) {
            return $params[$name];
        }
        return null;
    }
}
