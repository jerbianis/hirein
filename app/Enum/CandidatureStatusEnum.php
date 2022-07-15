<?php

namespace App\Enum;

use Illuminate\Support\Arr;

enum CandidatureStatusEnum:string
{
    case New='New';
    case InProcess='InProcess';
    case QuizTest='QuizTest';
    case Interview='Interview';
    case Accepted='Accepted';
    case Rejected='Rejected';

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

