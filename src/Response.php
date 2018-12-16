<?php

namespace Viloveul\Http;

use Symfony\Component\HttpFoundation\JsonResponse;
use Viloveul\Http\Contracts\Response as IResponse;

class Response extends JsonResponse implements IResponse
{

}
