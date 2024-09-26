<?php

namespace App\Enums;

class ActorTypeEnum
{

    const Teacher = 'Teacher';
    const Student = 'Student';

    public static function toArray()
    {
        return [
            self::Teacher,
            self::Student,
        ];

    }


}
