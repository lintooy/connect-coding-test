<?php

namespace App\Http\Requests;

use App\Enums\JobStatus;
use Illuminate\Foundation\Http\FormRequest;

class JobUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'company_id'   => 'required|exists:companies,id',
            'job_title_id' => 'required|exists:job_titles,id',
            'description'  => 'required|max:20000',
            'status'       => 'required|enum_key:' . JobStatus::class,
        ];
    }
}
