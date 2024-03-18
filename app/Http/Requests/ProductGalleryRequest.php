<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Models\ProductGallery;
use App\Traits\UploadImage;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ProductGalleryRequest extends FormRequest
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
            'image' => ['required' , 'image' , 'max:2048', 'mimes:png,jpg,jpeg']
        ];
    }

    /**
     * on update set validation rules 
     *
     * @return array
     */
    protected function onUpdate() {
        return [
            'image' => ['image' , 'max:2048', 'mimes:png,jpg,jpeg']
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
            'image' => 'صورة المنتج'
        ];
    }

    public function store($id)
    {
        Product::findOrFail($id)->images()->create([
            'image' => $this->upload_image($this->image , 'products' , 800 , 800),
            'created_by' => auth()->id()
        ]);
    }

    public function update($image)
    {
        $data = $this->all();

        if ($this->image) {
            Storage::disk('s3.assets')->delete('assets/'.$image->image);
            $data['image'] = $this->upload_image($this->image , 'products' , 800 , 800);

            $data['updated_by'] = auth()->id();
        }

        $image->update($data);
    }
}
