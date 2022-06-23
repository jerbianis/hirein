<?php

namespace App\Enum;

use Illuminate\Support\Arr;

enum MainActivityEnum:string
{
    case Manufacturing='Manufacturing industries';
    case IT='IT services';
    case Communications='Communications';
    case Transportation='Transportation';
    case Education='Education and teaching';
    case Training='Professional training';
    case Health='Healthcare';
    case Cultural='Production and cultural industries activities';
    case Animation='Animation of young people, leisure, supervision of childhood and protection of the elderly';
    case Environmental='Environmental';
    case CivilEng='Civil engineering';
    case Property='Property promotion';
    case Assistance='Services for studies, advice, expertise and assistance';
    case Research='Research and development services';
    case Other='Other activities';

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
