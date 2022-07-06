<?php

namespace App\Http\Requests;

use App\Enum\DegreeTypeEnum;
use App\Enum\OfferTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateJobOfferRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'title'         =>  ['required','string','max:255'],
            'description'   =>  ['required'],
            'city'          =>  ['nullable','string','min:3','max:25'],
            'type'          =>  ['nullable',Rule::in(OfferTypeEnum::names())],
            'degree'        =>  ['nullable',Rule::in(DegreeTypeEnum::names())],
            'offer_start_on'=>  ['required','date'],
            'offer_ends_on' =>  ['nullable','date','after_or_equal:offer_start_on']
        ];
    }
}
