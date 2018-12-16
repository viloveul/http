<?php

namespace Viloveul\Http\Contracts;

interface Response
{
    public function send();

    /**
     * @param array $data
     */
    public function setData($data = []);

    /**
     * @param $code
     * @param $text
     */
    public function setStatus($code, $text = null);
}
