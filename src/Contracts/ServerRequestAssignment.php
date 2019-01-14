<?php

namespace Viloveul\Http\Contracts;

use ArrayAccess;
use IteratorAggregate;
use JsonSerializable;

interface ServerRequestAssignment extends ArrayAccess, IteratorAggregate, JsonSerializable
{
    public function getAttributes(): array;

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes): void;
}
