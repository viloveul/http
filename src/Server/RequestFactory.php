<?php

namespace Viloveul\Http\Server;

use Psr\Http\Message\ServerRequestFactoryInterface as IServerRequestFactory;
use Psr\Http\Message\ServerRequestInterface as IServerRequest;
use Viloveul\Http\Server\Request as ServerRequest;
use Viloveul\Http\UploadedFileFactory;
use Zend\Diactoros as ZendDiactorosFunction;

class RequestFactory implements IServerRequestFactory
{
    /**
     * @var string
     */
    protected static $apacheRequestHeaders = 'apache_request_headers';

    /**
     * @param string $method
     * @param $uri
     * @param array  $serverParams
     */
    public function createServerRequest(string $method, $uri, array $serverParams = []): IServerRequest
    {
        $uploadedFiles = [];

        return new ServerRequest(
            $serverParams,
            $uploadedFiles,
            $uri,
            $method,
            'php://temp'
        );
    }

    /**
     * @param array $server
     * @param array $query
     * @param array $body
     * @param array $cookies
     * @param array $files
     */
    public static function fromGlobals(array $server = null, array $query = null, array $body = null, array $cookies = null, array $files = null): IServerRequest
    {

        $server = static::prepareServer($server ?: $_SERVER);
        $files = static::prepareFiles($files ?: $_FILES);
        $headers = ZendDiactorosFunction\marshalHeadersFromSapi($server);

        if (null === $cookies && array_key_exists('cookie', $headers)) {
            $cookies = ZendDiactorosFunction\parseCookieHeader($headers['cookie']);
        }

        return new ServerRequest(
            $server,
            $files,
            ZendDiactorosFunction\marshalUriFromSapi($server, $headers),
            ZendDiactorosFunction\marshalMethodFromSapi($server),
            'php://input',
            $headers,
            $cookies ?: $_COOKIE,
            $query ?: $_GET,
            $body ?: $_POST,
            ZendDiactorosFunction\marshalProtocolVersionFromSapi($server)
        );
    }

    /**
     * @param array $params
     */
    protected static function prepareFiles(array $params)
    {
        $files = UploadedFileFactory::normalizeUploadedFiles($params);
        return UploadedFileFactory::makeObjectUploadedFiles($files);
    }

    /**
     * @param array $params
     */
    protected static function prepareServer(array $params)
    {
        return ZendDiactorosFunction\normalizeServer($params, is_callable(static::$apacheRequestHeaders) ? static::$apacheRequestHeaders : null);
    }
}
