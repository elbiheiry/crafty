<?php

namespace App\Http\Requests;

use App\Models\Feature;
use App\Traits\UploadImage;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class FeatureReqeust extends FormRequest
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
     * on creation set validation rules 
     *
     * @return array
     */
    protected function onCreate() {
        return [
            'image' => ['required' , 'image' , 'max:2048', 'mimes:png,jpg,jpeg'],
            'title' => ['required' , 'string' , 'max:255']
        ];
    }

    /**
     * on update set validation rules 
     *
     * @return array
     */
    protected function onUpdate() {
        return [
            'image' => ['image' , 'max:2048', 'mimes:png,jpg,jpeg'],
            'title' => ['required' , 'string' , 'max:255']
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->isMethod('put') ? $this->onUpdate() : $this->onCreate();
    }

    public function attributes()
    {
        return [
            'image' => 'الصورة',
            'title' => 'العنوان'
        ];
    }

    public function store()
    {
        $data = [
            'en' => ['title' => $this->title],
            'ar' => ['title' => $this->title],
            'image' => $this->upload_image($this->image , 'features' , 512 , 512),
            'created_by' => auth()->id()
        ];

        Feature::create($data);
    }

    public function update($feature)
    {
        $data = [
            'en' => ['title' => $this->title],
            'ar' => ['title' => $this->title],
            'updated_by' => auth()->id()
        ];

        if ($this->image) {
            Storage::disk('s3.assets')->delete('assets/'.$feature->image);
            $data['image'] = $this->upload_image($this->image , 'features' , 512 , 512);
        }

        $feature->update($data);
    }
}
