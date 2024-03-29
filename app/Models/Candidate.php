<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->morphOne('App\Models\User', 'profile');
    }

    public function candidatures () {
        return $this->hasMany(Candidature::class);
    }
}
