<?php

namespace Viloveul\Http\Contracts;

use Psr\Http\Message\ServerRequestInterface;
use Viloveul\Http\Contracts\ServerRequestAssignment;

interface ServerRequest extends ServerRequestInterface
{
    /**
     * @param string $follower
     * @param array  $qs
     */
    public function getBaseUrl(string $follower, array $qs): string;

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

    /**
     * @param ServerRequestAssignment $object
     */
    public function loadPostTo(ServerRequestAssignment $object): ServerRequestAssignment;

    /**
     * @param ServerRequestAssignment $object
     */
    public function loadQueryTo(ServerRequestAssignment $object): ServerRequestAssignment;

    /**
     * @param ServerRequestAssignment $object
     */
    public function loadServerTo(ServerRequestAssignment $object): ServerRequestAssignment;
}
