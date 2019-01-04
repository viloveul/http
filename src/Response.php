<?php

namespace Viloveul\Http;

use Viloveul\Http\Contracts\Response as IResponse;
use Zend\Diactoros\Response\JsonResponse;

class Response extends JsonResponse implements IResponse
{
    /**
     * @param array $data
     * @param int   $status
     * @param array $headers
     * @param int   $encodingOptions
     */
    public function __construct($data = [], int $status = 200, array $headers = [], int $encodingOptions = JsonResponse::DEFAULT_JSON_FLAGS)
    {
        parent::__construct($data, $status, $headers, $encodingOptions);
    }

    public function send(): void
    {
        // Send response
        if (!headers_sent()) {
            // Headers
            foreach ($this->getHeaders() as $name => $values) {
                foreach ($values as $value) {
                    header(sprintf('%s: %s', $name, $value), false);
                }
            }
            header(
                vsprintf('HTTP/%s %s %s', [
                    $this->getProtocolVersion(),
                    $this->getStatusCode(),
                    $this->getReasonPhrase(),
                ])
            );
        }
        // Body
        $body = $this->getBody();
        if ($body->isSeekable()) {
            $body->rewind();
        }
        $contentLength = $this->getHeaderLine('Content-Length');
        if (!$contentLength) {
            $contentLength = $body->getSize();
        }
        if (isset($contentLength)) {
            $amountToRead = $contentLength;
            while ($amountToRead > 0 && !$body->eof()) {
                $data = $body->read(min(1, $amountToRead));
                echo $data;
                $amountToRead -= strlen($data);
                if (connection_status() != CONNECTION_NORMAL) {
                    break;
                }
            }
        }
    }

    /**
     * @param  $status
     * @param  $phrase
     * @return mixed
     */
    public function setStatus($status, $phrase = null): IResponse
    {
        return $this->withStatus($status, $phrase ?: '');
    }

    /**
     * @param $status
     * @param array     $errors
     */
    public function withErrors($status = self::STATUS_INTERNAL_SERVER_ERROR, array $errors = []): IResponse
    {
        return $this;
    }
}
