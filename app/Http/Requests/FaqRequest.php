<?php

namespace App\Http\Requests;

use App\Models\Faq;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FaqRequest extends FormRequest
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
            'faq_category_id' => ['not_in:0'],
            'order' => ['required' , 'numeric'],
            'question' => ['required' , 'string' , 'max:255'],
            'answer' => ['required']
        ];
    }

    public function attributes()
    {
        return [
            'question' => 'السؤال',
            'answer' => 'الإجابه',
            'faq_category_id' => 'القسم التابع له',
            'order' => 'الترتيب'
        ];
    }
    
    public function store()
    {
        $data = [
            'en' => [
                'question' => $this->question,
                'answer' => $this->answer
            ],
            'ar' => [
                'question' => $this->question,
                'answer' => $this->answer
            ],
            'created_by' => auth()->id(),
            'faq_category_id' => $this->faq_category_id,
            'order' => $this->order
        ];

        Faq::create($data);
    }

    public function update($faq)
    {

        $data = [
            'en' => [
                'question' => $this->question,
                'answer' => $this->answer
            ],
            'ar' => [
                'question' => $this->question,
                'answer' => $this->answer
            ],
            'updated_by' => auth()->id(),
            'faq_category_id' => $this->faq_category_id,
            'order' => $this->order
        ];

        $faq->update($data);
    }
}
