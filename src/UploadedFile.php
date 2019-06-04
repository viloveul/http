<?php

namespace Viloveul\Http;

use Zend\Diactoros\UploadedFile as ZendUploadedFile;
use Viloveul\Http\Contracts\UploadedFile as IUploadedFile;

class UploadedFile extends ZendUploadedFile implements IUploadedFile
{

}
