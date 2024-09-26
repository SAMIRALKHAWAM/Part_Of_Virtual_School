<?php

namespace App\Enums;

class OrderStatusEnum
{
const Pending = 'pending';
const Rejected = 'rejected';
const Accepted = 'accepted';

public static function toArray(){
    return [
        self::Rejected,
        self::Accepted,
    ];
}

    public static function toAll(){
        return [
            self::Pending,
            self::Rejected,
            self::Accepted,
        ];
    }

}
