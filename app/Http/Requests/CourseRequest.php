<?php

namespace App\Http\Requests;

use App\Models\Course;
use App\Traits\UploadImage;
use App\Traits\UploadVideo;
use Aws\Exception\AwsException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Meema\MediaConverter\Facades\MediaConvert;
use Aws\MediaConvert\MediaConvertClient;

class CourseRequest extends FormRequest
{
    use UploadImage , UploadVideo;
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

    public function attributes()
    {
        return [
            'image' => 'صورة الدورة',
            'video' => 'الفيديو التعريفي',
            'name' => 'عنوان الدورة',
            'course_category_id' => 'التصنيف',
            'products' => 'المنتجات المتعلقة',
            'level' => 'المستوي',
            'price' => 'سعر الدورة',
            'discount' => 'التخفيض الخاص بالدورة',
            'description' => 'عن الدورة',
            'lecturer_image' => 'صورة المحاضر',
            'lecturer_name' => 'إسم المحاضر',
            'lecturer_speciality' => 'تخصص المحاضر',
            'requirements' => 'متطلبات الدورة',
            'advantages' => 'مميزات الدورة'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => $this->routeIs('admin.courses.store') ? ['required' , 'image' , 'max:2048', 'mimes:png,jpg,jpeg,svg'] : ($this->image ? ['image' , 'max:2048','mimes:png,jpg,jpeg,svg'] : ''),
            'video' => $this->routeIs('admin.courses.store') ? ($this->type == 'free' ? ['required' , 'string' , 'max:255'] : ['required' , 'mimes:mp4,ogx,oga,ogv,ogg,webm']) : ($this->type == 'free' ? ['required' , 'string' , 'max:255'] :['mimes:mp4,ogx,oga,ogv,ogg,webm']) ,
            'name' => ['required' , 'string' , 'max:255'],
            'course_category_id' => ['not_in:0'],
            'level' => $this->type == 'paid' ? ['not_in:0'] : '',
            'lecturer_image' => $this->routeIs('admin.courses.store') && $this->type == 'paid' ? ['required' , 'image' , 'max:2048', 'mimes:png,jpg,jpeg,svg'] : ($this->lecturer_image && $this->type == 'paid' ? ['image' , 'max:2048','mimes:png,jpg,jpeg,svg'] : ''),
            'lecturer_name' => $this->type == 'paid' ? ['required' , 'string' , 'max:255'] : '',
            'lecturer_speciality' => $this->type == 'paid' ? ['required' , 'string' , 'max:255'] : '',
            'price' => $this->type == 'paid' ? ['required' , 'numeric'] : '',
            'discount' => $this->discount ? ['numeric']: '',
            'description' => $this->type == 'paid' ? ['required'] : '',
            'requirements' => $this->type == 'paid' ? ['required'] : '',
            'advantages' => $this->type == 'paid' ? ['required'] : ''
        ];
    }

    public function store($type)
    {
        // Set file attributes.
        if ($type == 'paid') {
            $filepath = '/videos';
            $file = $this->file('video');
            $filename = $this->video->hashName();
            File::streamUpload($filepath, $filename, $file, true);
            $video_url = Storage::disk('s3.videos')->url($filename);
        }else{
            $filename = $this->video;
            $video_url = $this->video;
        }
    
        $data = [
            'en' => [
                'name' => $this->name,
                'description' => $this->description,
                'lecturer_name' => $this->lecturer_name,
                'lecturer_speciality' => $this->lecturer_speciality,
                'requirements' => $this->requirements,
                'advantages' => $this->advantages
            ],
            'ar' => [
                'name' => $this->name,
                'description' => $this->description,
                'lecturer_name' => $this->lecturer_name,
                'lecturer_speciality' => $this->lecturer_speciality,
                'requirements' => $this->requirements,
                'advantages' => $this->advantages
            ],
            'image' => $this->upload_image($this->image , 'courses' , 740 , 440),
            'video' => $filename,
            'video_url' => $video_url,
            'course_category_id' => $this->course_category_id,
            'level' => $this->level,
            'price' => $this->price,
            'discount' => $this->discount,
            'lecturer_image' =>$this->lecturer_image ? $this->upload_image($this->lecturer_image , 'courses' , 100, 100) : null
        ];

        
        $course = Course::create($data);
        if ($this->products) {
            foreach ($this->products as $key => $product) {
                $course->products()->create([
                    'product_id' => $product
                ]);
            }
        }
        if ($type == 'paid') {
            $this->upload_video($course , $course->video , 'video_id');
        }
    }

    public function update($course)
    {
        $data = [
            'en' => [
                'name' => $this->name,
                'description' => $this->description,
                'lecturer_name' => $this->lecturer_name,
                'lecturer_speciality' => $this->lecturer_speciality,
                'requirements' => $this->requirements,
                'advantages' => $this->advantages
            ],
            'ar' => [
                'name' => $this->name,
                'description' => $this->description,
                'lecturer_name' => $this->lecturer_name,
                'lecturer_speciality' => $this->lecturer_speciality,
                'requirements' => $this->requirements,
                'advantages' => $this->advantages
            ],
            'course_category_id' => $this->course_category_id,
            'level' => $this->level,
            'price' => $this->price,
            'discount' => $this->discount,
            'slug' => $this->slug
        ];
        if ($this->video) {
            if ($course->price) {
                Storage::disk('s3.videos')->delete('videos/'.$course->video);

                $filepath = '/videos';
                $file = $this->file('video');
                $filename = $this->video->hashName();
                File::streamUpload($filepath, $filename, $file, true);

                $data['video'] = $filename;
                $data['video_url'] = $filename;

                $this->upload_video($course , $course->video , 'video_id');
            }else{
                $data['video'] = $this->video;
                $data['video_url'] = $this->video;
            }
            
        }

        if ($this->image) {
            Storage::disk('s3.assets')->delete('assets/'.$course->image);
            $data['image'] = $this->upload_image($this->image , 'courses' , 740 , 440);
        }

        if ($this->lecturer_image) {

            Storage::disk('s3.assets')->delete('assets/'.$course->lecturer_image);
            $data['lecturer_image'] = $this->upload_image($this->lecturer_image , 'courses' , 100, 100);
        }

        $course->update($data);

        if ($this->products) {
            $course->products()->delete();
            foreach ($this->products as $key => $product) {
                $course->products()->create([
                    'product_id' => $product
                ]);
            }
        }
    }
}
