<?php

namespace App\Http\Requests;

use App\Models\Article;
use App\Traits\UploadImage;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
class ArticleRequest extends FormRequest
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
            'inner_image' => ['required' , 'image' , 'max:2048', 'mimes:png,jpg,jpeg'],
            'outer_image' => ['required' , 'image' , 'max:2048', 'mimes:png,jpg,jpeg'],
            'title' => ['required' , 'string' , 'max:255'],
            'brief' => ['required'],
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
            'inner_image' => ['image' , 'max:2048', 'mimes:png,jpg,jpeg'],
            'outer_image' => ['image' , 'max:2048', 'mimes:png,jpg,jpeg'],
            'title' => ['required' , 'string' , 'max:255'],
            'brief' => ['required'],
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
            'inner_image' => 'الصورة الداخلية',
            'outer_image' => 'الصورة الخارجية',
            'title' => 'عنوان المقال',
            'brief' => 'بعض الكلمات عن المقال',
            'description' => 'وصف المقال'
        ];
    }

    public function store()
    {
        $data = [
            'en' => [
                'title' => $this->title,
                'brief' => $this->brief,
                'description' => $this->description
            ],
            'ar' => [
                'title' => $this->title,
                'brief' => $this->brief,
                'description' => $this->description
            ],
            //inner image
            'inner_image' => $this->upload_image($this->inner_image , 'articles' , 700 , 460),
            //outer image
            'outer_image' => $this->upload_image($this->outer_image , 'articles' , 650 , 430),
            'slug' => SlugService::createSlug(Article::class , 'slug' , $this->title , ['unique' => true]),
            'created_by' => auth()->id()
        ];

        $article = Article::create($data);

        if ($this->products) {
            foreach ($this->products as $product) {
                $article->products()->create([
                    'product_id' => $product
                ]);
            }
        }

        if ($this->courses) {
            foreach ($this->courses as $course) {
                $article->courses()->create([
                    'course_id' => $course
                ]);
            }
        }
        
    }

    public function update($article)
    {
        $data = [
            'en' => [
                'title' => $this->title,
                'brief' => $this->brief,
                'description' => $this->description
            ],
            'ar' => [
                'title' => $this->title,
                'brief' => $this->brief,
                'description' => $this->description
            ],
            'slug' => $this->slug,
            'updated_by' => auth()->id()
        ];

        $filepath = '/assets';

        if ($this->inner_image) {
            Storage::disk('s3.assets')->delete('assets/'.$article->inner_image);
            $data['inner_image'] = $this->upload_image($this->inner_image , 'articles' , 700 , 460);
        }

        if ($this->outer_image) {
            Storage::disk('s3.assets')->delete('assets/'.$article->outer_image);
            $data['outer_image'] = $this->upload_image($this->outer_image , 'articles' , 650 , 430);
        }

        $article->update($data);

        if ($this->products) {
            $article->products()->delete();
            foreach ($this->products as $product) {
                $article->products()->create([
                    'product_id' => $product
                ]);
            }
        }

        if ($this->courses) {
            $article->courses()->delete();
            foreach ($this->courses as $course) {
                $article->courses()->create([
                    'course_id' => $course
                ]);
            }
        }
    }
}
