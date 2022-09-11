<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function invitedEmailList(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? explode(';',$value) : null ,
        );
    }

    public function candidature() {
        return $this->belongsTo(Candidature::class);
    }

    public function interviewURL()
    {
        $secret = ENV('secretkey');
        $generatedToken = substr(sha1($secret .  $this->id), 0, 8) ;
        return "http://127.0.0.1:8000/interview/" . $this->id . "?token=" . $generatedToken;
    }
}
