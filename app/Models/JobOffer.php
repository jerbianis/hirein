<?php

namespace App\Models;

use App\Enum\DegreeTypeEnum;
use App\Enum\OfferTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'type'  =>  OfferTypeEnum::class,
        'degree'=>  DegreeTypeEnum::class
    ];
    protected $with=[
        'enterprise',
    ];

    public function enterprise() {
        return $this->belongsTo(Enterprise::class);
    }
    public function candidatures () {
        return $this->hasMany(Candidature::class);
    }

}
