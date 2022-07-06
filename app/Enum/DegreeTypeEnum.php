<?php

namespace App\Enum;

use Illuminate\Support\Arr;

enum DegreeTypeEnum:string
{
    case Baccalaureate='Baccalaureate';
    case Bachelor='Bachelor';
    case Master='Master';
    case Engineer='Engineer';
    case Doctoral='Doctoral';

    /**
     * @return array
     */
    public static function names(): array
    {
        return Arr::pluck(self::cases(),'name');
    }

    /**
     * @return string
     */
    public static function getValue(string $name): string
    {
        $arrayNameValue=Arr::pluck(self::cases(),'value','name');
        return Arr::get($arrayNameValue,$name);
    }
}
