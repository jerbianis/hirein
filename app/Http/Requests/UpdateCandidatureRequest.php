<?php

namespace App\Http\Requests;

use App\Enum\CandidatureStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCandidatureRequest extends FormRequest
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
            'status'    =>  ['required',Rule::in(CandidatureStatusEnum::names())]
        ];
    }
}
