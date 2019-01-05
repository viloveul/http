<?php

namespace Viloveul\Http\Contracts;

use Psr\Http\Message\UploadedFileFactoryInterface;

interface UploadedFileFactory extends UploadedFileFactoryInterface
{
    /**
     * @param array $files
     */
    public static function makeObjectUploadedFiles(array $files): array;

    /**
     * @param array $files
     */
    public static function normalizeUploadedFiles(array $files): array;
}
