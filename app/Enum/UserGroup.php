<?php

namespace App\Enum;

class UserGroup
{
    public const ADMIN = 'ADMIN';
    public const AGENT = 'AGENT';
    public const SUBSCRIBER = 'SUBSCRIBER';
    public const SUPER_AGENT = 'SUPER-AGENT';
    public const MERCHANT = 'MERCHANT';
    public const DISTRIBUTOR = 'DISTRIBUTOR';

    public const VALUES = [
        'ADMIN' => self::ADMIN,
        'AGENT' => self::AGENT,
        'SUBSCRIBER' => self::SUBSCRIBER,
        'SUPER_AGENT' => self::SUPER_AGENT,
        'MERCHANT' => self::MERCHANT,
        'DISTRIBUTOR' => self::DISTRIBUTOR,
    ];

    public static function get($type)
    {
        $enum = data_get(self::VALUES,$type);
        return [
                'id' => $enum,
                'title' => __("enums.{$enum}")
        ];
    }
}
