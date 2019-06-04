<?php

namespace Viloveul\Http\Contracts;

use Psr\Http\Message\ResponseInterface;

interface Response extends ResponseInterface
{
    const STATUS_CONTINUE = 100;

    const STATUS_PROCESSING = 102;

    const STATUS_OK = 200;

    const STATUS_CREATED = 201;

    const STATUS_ACCEPTED = 202;

    const STATUS_NO_CONTENT = 204;

    const STATUS_MOVED_PERMANENTLY = 301;

    const STATUS_FOUND = 302;

    const STATUS_NOT_MODIFIED = 304;

    const STATUS_RESERVED = 306;

    const STATUS_TEMPORARY_REDIRECT = 307;

    const STATUS_PERMANENTLY_REDIRECT = 308;

    const STATUS_BAD_REQUEST = 400;

    const STATUS_UNAUTHORIZED = 401;

    const STATUS_FORBIDDEN = 403;

    const STATUS_NOT_FOUND = 404;

    const STATUS_METHOD_NOT_ALLOWED = 405;

    const STATUS_NOT_ACCEPTABLE = 406;

    const STATUS_CONFLICT = 409;

    const STATUS_LENGTH_REQUIRED = 411;

    const STATUS_PRECONDITION_FAILED = 412;

    const STATUS_UNSUPPORTED_MEDIA_TYPE = 415;

    const STATUS_LOCKED = 423;

    const STATUS_UNPROCESSABLE_ENTITY = 422;

    const STATUS_PRECONDITION_REQUIRED = 428;

    const STATUS_INTERNAL_SERVER_ERROR = 500;

    const STATUS_BAD_GATEWAY = 502;

    const STATUS_SERVICE_UNAVAILABLE = 503;

    const STATUS_GATEWAY_TIMEOUT = 504;

    public function send(): void;

    /**
     * @param $status
     * @param $phrase
     */
    public function setStatus($status, $phrase = null): self;

    /**
     * @param $status
     * @param array     $errors
     */
    public function withErrors($status = self::STATUS_INTERNAL_SERVER_ERROR, array $errors = []): self;
}
