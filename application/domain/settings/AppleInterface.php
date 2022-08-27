<?php
namespace application\domain\settings;

interface AppleInterface
{
    const STATUS_IN_TREE = 1;
    const STATUS_FALL = 2;
    const STATUS_ROTTEN = 3;
    const STATUS_DELETE = 4;

    const STATUSES = [
        self::STATUS_IN_TREE,
        self::STATUS_FALL,
        self::STATUS_ROTTEN,
        self::STATUS_DELETE,
    ];
    const COLORS =[
        'green',
        'red',
        'yellow'
    ];

    const ROTTEN_TIME = 300;
}