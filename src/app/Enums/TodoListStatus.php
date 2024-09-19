<?php


namespace App\Enums;

class TodoListStatus
{
    const ACTIVE = 'active';
    const DONE = 'done';


    public static function getStatusList()
    {
        return [
            self::ACTIVE,
            self::DONE
        ];
    }
}
