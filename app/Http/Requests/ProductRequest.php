<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Traits\UploadImage;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
class ProductRequest extends FormRequest
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
            'name' => ['required' , 'string' , 'max:255'],
            'product_category_id' => ['not_in:0'],
            'price' => ['required' , 'numeric'],
            'quantity' => ['required' , 'numeric'],
            'description' => ['required']
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
            'product_category_id' => ['not_in:0'],
            'price' => ['required' , 'numeric'],
            'quantity' => ['required' , 'numeric'],
            'description' => ['required']
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
            'image' => 'صورة المنتج',
            'name' => 'إسم المنتج',
            'product_category_id' => 'القسم',
            'price' => 'سعر المنتج',
            'quantity' => 'الكمية المتاحة من المنتج',
            'description' => 'وصف المنتج',
            'slug' => 'إسم المنتج في ال url'
        ];
    }

    public function store()
    {
        $data = [
            'en' => [
                'name' => $this->name,
                'description' => $this->description
            ],
            'ar' => [
                'name' => $this->name,
                'description' => $this->description
            ],
            'product_category_id' => $this->product_category_id,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'image' => $this->upload_image($this->image , 'products' , 1000 , 1000),
            'slug' => SlugService::createSlug(Product::class , 'slug' , $this->name , ['unique' => true]),
            'created_by' => auth()->id()
        ];

        Product::create($data);
    }

    public function update($product)
    {
        $data = [
            'en' => [
                'name' => $this->name,
                'description' => $this->description
            ],
            'ar' => [
                'name' => $this->name,
                'description' => $this->description
            ],
            'product_category_id' => $this->product_category_id,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'slug' => $this->slug,
            'updated_by' => auth()->id()
        ];

        if ($this->image) {
            Storage::disk('s3.assets')->delete('assets/'.$product->image);

            $data['image'] = $this->upload_image($this->image , 'products' , 1000 , 1000);
        }

        $product->update($data);
    }
}
