<?php

namespace App\Http\Requests;

use App\Models\ProductCategory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductCategoryRequest extends FormRequest
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
            'name' => ['required' , 'string' , 'max:225']
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'الإسم'
        ];
    }

    public function store()
    {
        $data = [
            'en' => ['name' => $this->name],
            'ar' => ['name' => $this->name],
            'created_by' => auth()->id()
        ];

        ProductCategory::create($data);
    }

    public function update($category)
    {
        $data = [
            'en' => ['name' => $this->name],
            'ar' => ['name' => $this->name],
            'updated_by' => auth()->id()
        ];
        
        $category->update($data);
    }
}
