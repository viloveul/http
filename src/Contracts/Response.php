<?php

namespace Viloveul\Http\Contracts;

interface Response
{
    /**
     * @param $status
     * @param $title
     * @param $detail
     * @param null      $pointer
     */
    public function addError($status, $title, $detail = null, $pointer = null);

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
