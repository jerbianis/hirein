<?php

namespace App\Http\Requests;

use App\Models\JobOffer;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreCandidatureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $job_offers=JobOffer::where('visibility',true)
            ->where('offer_start_on','<=',Carbon::now())
            ->where(function ($query) {
                $query->where('offer_ends_on','>=',Carbon::now())
                    ->orwhere('offer_ends_on',null);
            })->get('id');
        if (!$job_offers->contains($this->offer)) {
            return false;
        }else {
            return true;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
