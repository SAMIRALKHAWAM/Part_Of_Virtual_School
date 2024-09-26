<?php

namespace App\Enums;

class VideoTypeEnum
{

    const TextUrl = 'textUrl';
    const UploadedUrl = 'uploadedUrl';

    public static function toArray(){

        return [
            self::TextUrl,
            self::UploadedUrl,
        ];
    }

}
