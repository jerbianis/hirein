<?php

namespace App\Models;

use App\Enum\CandidatureStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status'=> CandidatureStatusEnum::class
    ];

    public function candidate() {
        return $this->belongsTo(Candidate::class);
    }

    public function job_offer() {
        return $this->belongsTo(JobOffer::class);
    }
}
