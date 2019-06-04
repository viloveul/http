<?php

namespace Viloveul\Http;

use Viloveul\Http\UploadedFile;
use Zend\Diactoros as ZendDiactoros;
use Psr\Http\Message\StreamInterface as IStream;
use Psr\Http\Message\UploadedFileInterface as IUploadedFile;
use Viloveul\Http\Contracts\UploadedFileFactory as IUploadedFileFactory;

class UploadedFileFactory implements IUploadedFileFactory
{
    /**
     * @param IStream    $stream
     * @param int        $size
     * @param nullint    $error
     * @param string     $filename
     * @param nullstring $type
     */
    public function createUploadedFile(
        IStream $stream,
        int $size = null,
        int $error = 0,
        string $filename = null,
        string $type = null
    ): IUploadedFile {
        if ($size === null) {
            $size = $stream->getSize();
        }

        return new UploadedFile($stream, $size, $error, $filename, $type);
    }

    /**
     * @param array $params
     */
    public static function normalizeUploadedFiles(array $params): array
    {
        return ZendDiactoros\normalizeUploadedFiles($params);
    }
}
