<?php

namespace App\Http\Requests;

use App\Models\MembershipBenefit;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class MembershipBenefitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors()->first(), 400));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required' , 'string' , 'max:255'],
            'description' => ['required']
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'عنوان الميزة',
            'description' => 'وصف الميزة'
        ];
    }

    public function store()
    {
        $data = [
            'en' => [
                'title' => $this->title,
                'description' => $this->description
            ],
            'ar' => [
                'title' => $this->title,
                'description' => $this->description
            ],
            'created_by' => auth()->id()
        ];

        MembershipBenefit::create($data);
    }

    public function update($benefit)
    {
        $data = [
            'en' => [
                'title' => $this->title,
                'description' => $this->description
            ],
            'ar' => [
                'title' => $this->title,
                'description' => $this->description
            ],
            'updated_by' => auth()->id()
        ];

        $benefit->update($data);
    }
}
