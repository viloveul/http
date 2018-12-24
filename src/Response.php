<?php

namespace Viloveul\Http;

use Symfony\Component\HttpFoundation\JsonResponse;
use Viloveul\Http\Contracts\Response as IResponse;

class Response extends JsonResponse implements IResponse
{
    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @param  $status
     * @param  $title
     * @param  $detail
     * @param  null      $pointer
     * @return mixed
     */
    public function addError($status, $title, $detail = null, $pointer = null)
    {
        $this->errors[] = [
            'status' => $status,
            'title' => $title,
            'detail' => $detail ?: $title,
            'source' => ['pointer' => $pointer],
        ];
        return $this;
    }

    /**
     * @param  $code
     * @param  $text
     * @return mixed
     */
    public function setStatus($code, $text = null)
    {
        return $this->setStatusCode($code, $text);
    }

    /**
     * @param  $code
     * @return mixed
     */
    public function withError($code = null)
    {
        if (count($this->errors) > 0) {
            is_null($code) or $this->setStatus($code);
            $this->setData([
                'errors' => $this->errors,
            ]);
        }
        return $this;
    }
}
