<?php

namespace Viloveul\Http;

use Viloveul\Http\Contracts\UploadedFileFactory as IUploadedFileFactory;
use Viloveul\Http\UploadedFile;
use Zend\Diactoros\UploadedFileFactory as ZendUploadedFileFactory;

class UploadedFileFactory extends ZendUploadedFileFactory implements IUploadedFileFactory
{
    /**
     * @param array $params
     */
    public static function normalizeUploadedFiles(array $params): array
    {
        $uploadedFiles = [];
        if (isset($params) && !empty($params)) {
            foreach ($params as $category => $files) {
                foreach (['name', 'tmp_name', 'error', 'type', 'size'] as $key) {
                    if (array_key_exists($key, $files)) {
                        if (is_scalar($files[$key])) {
                            $uploadedFiles[$category][$key] = $files[$key];
                        } else {
                            static::recursive($category, $files[$key], $key, $uploadedFiles);
                        }
                    }
                }
            }
        }
        return array_map(function ($file) {
            return new UploadedFile(
                $file['tmp_name'],
                $file['size'],
                $file['error'],
                $file['name'],
                $file['type']);
        }, $uploadedFiles);
    }

    /**
     * @param $category
     * @param $file
     * @param $key
     * @param $files
     */
    protected static function recursive($category, $file, $key, &$files)
    {
        foreach ($file as $name => $value) {
            if (is_scalar($value)) {
                $files[$category . '.' . $name][$key] = $value;
            } else {
                static::recursive($category . '.' . $name, $value, $key, $files);
            }
        }
    }
}
