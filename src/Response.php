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

    public function send()
    {
        if (count($this->errors) > 0) {
            $this->setData([
                'errors' => $this->errors,
            ]);
            if (0 === strpos($this->getStatusCode(), 2)) {
                $this->setStatus(400);
            }
        }
        return parent::send();
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
}
