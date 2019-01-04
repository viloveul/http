<?php

namespace Viloveul\Http;

use Viloveul\Http\Contracts\UploadedFile as IUploadedFile;
use Zend\Diactoros\UploadedFile as ZendUploadedFile;

class UploadedFile extends ZendUploadedFile implements IUploadedFile
{

}
