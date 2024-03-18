<?php

namespace App\Http\Requests;

use App\Models\Package;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
class PackageRequest extends FormRequest
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
     * on creation set validation rules 
     *
     * @return array
     */
    protected function onCreate() {
        return [
            'image' => ['required' , 'image' , 'max:2048', 'mimes:png,jpg,jpeg'],
            'name' => ['required' , 'string' , 'max:255'],
            'price' => ['required' , 'numeric'],
            'type' => ['not_in:0']
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
            'name' => ['required' , 'string' , 'max:255'],
            'price' => ['required' , 'numeric'],
            'type' => ['not_in:0']
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
            'name' => 'إسم الباقة',
            'price' => 'سعر الباقة',
            'type' => 'نوع الباقة'
        ];
    }

    public function store()
    {
        $data = [
            'en' => [
                'name' => $this->name
            ],
            'ar' => [
                'name' => $this->name
            ],
            'image' => $this->upload_image($this->image , 'packages' , 200, 200),
            'price' => $this->price,
            'type' => $this->type,
            'created_by' => auth()->id()
        ];

        Package::create($data);
    }

    public function update($package)
    {
        $data = [
            'en' => [
                'name' => $this->name
            ],
            'ar' => [
                'name' => $this->name
            ],
            'price' => $this->price,
            'type' => $this->type,
            'updated_by' => auth()->id()
        ];

        if ($this->image) {
            Storage::disk('s3.assets')->delete('assets/'.$package->image);
            $data['image'] = $this->upload_image($this->image , 'packages' , 200, 200);
        }

        $package->update($data);
    }
}
