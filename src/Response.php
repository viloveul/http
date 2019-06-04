<?php

namespace Viloveul\Http;

use InvalidArgumentException;
use Zend\Diactoros\Response\JsonResponse;
use Viloveul\Http\Contracts\Response as IResponse;

class Response extends JsonResponse implements IResponse
{
    /**
     * @param $data
     * @param nullint $status
     * @param array   $headers
     * @param int     $encodingOptions
     */
    public function __construct(
        $data = null,
        int $status = 200,
        array $headers = [],
        int $encodingOptions = JsonResponse::DEFAULT_JSON_FLAGS
    ) {
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
     * @param  $status
     * @param  array     $errors
     * @return mixed
     */
    public function withErrors($status = self::STATUS_INTERNAL_SERVER_ERROR, array $errors = []): IResponse
    {
        $markedErrors = [];
        foreach ($errors as $key => $values) {
            if (is_scalar($values)) {
                $error = [
                    'source' => ['pointer' => ''],
                    'detail' => $values,
                ];
                if (is_string($key)) {
                    $error['title'] = $key;
                }
                $markedErrors[] = $error;
            } else {
                if (!isset($values['detail'])) {
                    throw new InvalidArgumentException('Values must be an array of string or must be an array containing an array with non-null index "detail"');
                }
                $error = [];
                foreach ($values as $index => $value) {
                    $error[$index] = $value;
                }
                $markedErrors[] = $error;
            }
        }
        $response = $this->withPayload([
            'errors' => $markedErrors,
        ]);
        return $response->withStatus($status);
    }
}
