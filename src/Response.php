<?php

namespace Viloveul\Http;

use Symfony\Component\HttpFoundation\JsonResponse;
use Viloveul\Http\Contracts\Response as IResponse;

class Response extends JsonResponse implements IResponse
{
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
