<?php

namespace Viloveul\Http\Server;

use Viloveul\Http\Contracts\ServerRequest as IServerRequest;
use Viloveul\Http\Contracts\ServerRequestAssignment as IServerRequestAssignment;
use Zend\Diactoros\ServerRequest;

class Request extends ServerRequest implements IServerRequest
{
    /**
     * @var mixed
     */
    protected $myBaseUrl = null;

    /**
     * @param string $follower
     * @param array  $qs
     */
    public function getBaseUrl(string $follower = '/', array $qs = []): string
    {
        if (is_null($this->myBaseUrl)) {
            $uri = $this->getUri();
            $this->myBaseUrl = $uri->getScheme() . '://' . $uri->getHost();
            if ($port = $uri->getPort()) {
                $this->myBaseUrl .= ":{$port}";
            }
        }
        if (strpos($follower, '?') !== false) {
            $parts = explode('?', $follower, 2);
            $follower = $parts[0];
            if (!empty($parts[1])) {
                parse_str($parts[1], $tmp);
                $qs = array_merge($tmp, $qs);
            }
        }
        $res = rtrim($this->myBaseUrl . '/' . trim($follower, '/'), '/');
        if (!empty($qs)) {
            $res .= '?' . http_build_query($qs);
        }
        return $res;
    }

    /**
     * @param  string     $name
     * @param  $default
     * @return mixed
     */
    public function getPost(string $name, $default = null)
    {
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
        $object->setAttributes($this->getParsedBody() ?: []);
        return $object;
    }

    /**
     * @param  IServerRequestAssignment $object
     * @return mixed
     */
    public function loadQueryTo(IServerRequestAssignment $object): IServerRequestAssignment
    {
        $object->setAttributes($this->getQueryParams() ?: []);
        return $object;
    }

    /**
     * @param  IServerRequestAssignment $object
     * @return mixed
     */
    public function loadServerTo(IServerRequestAssignment $object): IServerRequestAssignment
    {
        $object->setAttributes($this->getServerParams() ?: []);
        return $object;
    }
}
