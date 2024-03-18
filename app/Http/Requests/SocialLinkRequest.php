<?php

namespace App\Http\Requests;

use App\Models\SocialLink;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SocialLinkRequest extends FormRequest
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
            'name' => ['required' , 'string' , 'max:225'],
            'link' => ['required' , 'url']
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'الإسم',
            'link' => 'الرابط'
        ];
    }

    public function store()
    {
        $data = $this->all();
        $data['created_by'] = auth()->id();
        SocialLink::create($data);
    }

    public function update($link)
    {
        $data = $this->all();
        $data['updated_by'] = auth()->id();
        $link->update($data);
    }
}
