<?php

namespace Viloveul\Http\Server;

use Viloveul\Http\Contracts\ServerRequest as IServerRequest;
use Viloveul\Http\Contracts\ServerRequestAssignment as IServerRequestAssignment;
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

    /**
     * @param  IServerRequestAssignment $object
     * @return mixed
     */
    public function loadPostTo(IServerRequestAssignment $object): IServerRequestAssignment
    {
        $params = $this->getParsedBody() ?: [];
        foreach ($params as $key => $value) {
            $object->setAttribute($key, $value);
        }
        return $object;
    }

    /**
     * @param  IServerRequestAssignment $object
     * @return mixed
     */
    public function loadQueryTo(IServerRequestAssignment $object): IServerRequestAssignment
    {
        $params = $this->getQueryParams() ?: [];
        foreach ($params as $key => $value) {
            $object->setAttribute($key, $value);
        }
        return $object;
    }

    /**
     * @param  IServerRequestAssignment $object
     * @return mixed
     */
    public function loadServerTo(IServerRequestAssignment $object): IServerRequestAssignment
    {
        $params = $this->getServerParams() ?: [];
        foreach ($params as $key => $value) {
            $object->setAttribute($key, $value);
        }
        return $object;
    }
}
