<?php

namespace App\Enum;

use Illuminate\Support\Arr;

enum OfferTypeEnum:string
{
    case Internship='Internship';
    case CIVP='CIVP';
    case CDI='CDI';
    case CDD='CDD';
    case Freelance='Freelance';

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
