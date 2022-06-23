<?php

namespace App\Models;

use App\Enum\MainActivityEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'main_activity'=> MainActivityEnum::class
    ];

    public function user()
    {
        return $this->morphOne('App\Models\User', 'profile');
    }
}
