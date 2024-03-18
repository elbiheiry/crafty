<?php

namespace App\Http\Requests;

use App\Models\About;
use App\Traits\UploadImage;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
class AboutReqeust extends FormRequest
{
    use UploadImage;

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
            'image' => ['image' , 'max:2048' , 'mimes:png,jpg,jpeg'],
            'title' => ['required' , 'string' , 'max:255'],
            'description' => ['required']
        ];
    }

    public function attributes()
    {
        return [
            'image' => 'الصورة',
            'title' => 'العنوان',
            'description' => 'الوصف'
        ];
    }

    public function update()
    {
        $about = About::firstOrFail();

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

        if ($this->image) {
            $data['image'] = $this->upload_image($this->image , 'about' , 540 , 430);
        }

        $about->update($data);
    }
}
