<?php

namespace App\Http\Requests;

use App\Models\Setting;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SettingRequest extends FormRequest
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
            'email' => ['required' , 'email' , 'string' , 'max:255'],
            'phone' => ['required'],
            'map' => ['required'],
            'privacy' => ['required'],
            'terms' => ['required']
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'البريد الإلكتروني',
            'phone' => 'رقم الهاتف',
            'map' => 'رابط الخريطه',
            'privacy' => 'سياسة الخصوصية',
            'terms' => 'الشروط والأحكام'
        ];
    }

    public function update()
    {
        $data = [
            'en' => [
                'privacy' => $this->privacy,
                'terms' => $this->terms
            ],
            'ar' => [
                'privacy' => $this->privacy,
                'terms' => $this->terms
            ],
            'email' => $this->email,
            'phone' => $this->phone,
            'map' => $this->map,
            'updated_by' => auth()->id()
        ];
        Setting::firstOrFail()->update($data);
    }
}
