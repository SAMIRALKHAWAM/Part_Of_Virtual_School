<?php

namespace App\Enums;

class QuestionTypeEnum
{

    const Automatic = 'automatic';
    const Manual = 'manual';

    public static function toArray(){
        return [
            self::Automatic,
            self::Manual,
        ];
    }

}
