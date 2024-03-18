<?php

namespace App\Http\Requests;

use App\Models\CourseCategory;
use App\Traits\UploadImage;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
class CourseCategoryRequest extends FormRequest
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
            'image' => ['required' , 'image' , 'max:2048', 'mimes:png,jpg,jpeg,svg'],
            'name' => ['required' , 'string' , 'max:255']
        ];
    }

    /**
     * on update set validation rules 
     *
     * @return array
     */
    protected function onUpdate() {
        return [
            'image' => ['image' , 'max:2048', 'mimes:png,jpg,jpeg,svg'],
            'name' => ['required' , 'string' , 'max:255'],
            'slug' => ['required' , 'string' , 'max:255']
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
            'name' => 'إسم القسم',
            'image' => 'صورة القسم'
        ];
    }

    public function store()
    {
        $data = [
            'en' => ['name' => $this->name],
            'ar' => ['name' => $this->name],
            'image' => $this->upload_image($this->image , 'courses' , 36 , 38),
            'created_by' => auth()->id(),
            'slug' => SlugService::createSlug(CourseCategory::class , 'slug' , $this->name , ['unique' => true])
        ];

        CourseCategory::create($data);
    }

    public function update($category)
    {
        $data = [
            'en' => ['name' => $this->name],
            'ar' => ['name' => $this->name],
            'updated_by' => auth()->id(),
            'slug' => $this->slug
        ];

        if($this->image){
            Storage::disk('s3.assets')->delete('assets/'.$category->image);
            $data['image'] = $this->upload_image($this->image , 'courses' , 36 , 38);
        }
        
        $category->update($data);
    }
}
