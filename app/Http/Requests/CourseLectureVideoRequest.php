<?php

namespace App\Http\Requests;

use App\Models\CourseLecture;
use App\Models\CourseLectureVideo;
use App\Traits\UploadVideo;
use Aws\Exception\AwsException;
use Aws\MediaConvert\MediaConvertClient;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CourseLectureVideoRequest extends FormRequest
{
    use UploadVideo;

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
            'name' => ['required' , 'string' , 'max:255'],
            'link' => $this->routeIs('admin.courses.lectures.videos.store') ? ['required'] : ''
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'الإسم',
            'link' => 'الرابط'
        ];
    }

    public function store($id)
    {
        $lecture = CourseLecture::findOrFail($id);

        if ($lecture->course['price'] == null) {
            $filename = $this->link;
        }else{
            $filepath = '/videos';
            $file = $this->file('link');
            $filename = $this->link->hashName();
            File::streamUpload($filepath, $filename, $file, true);
        }
        
        $data = [
            'en' => ['name' => $this->name],
            'ar' => ['name' => $this->name],
            'course_lecture_id' => $id,
            'link' => $filename,
            'link_url' => $filename
        ];
        $video = CourseLectureVideo::create($data);

        if ($lecture->course['price'] != null) {
            $this->upload_video($video , $video->link , 'link_id');
        }
    }

    public function update($video)
    {
        $data = [
            'en' => ['name' => $this->name],
            'ar' => ['name' => $this->name],
        ];

        $lecture = CourseLecture::findOrFail($video->course_lecture_id);

        if ($this->link) {
            if ($lecture->course['price'] == null) {
                $filename = $this->link;
            }else{
                Storage::disk('s3.videos')->delete('videos/'.$video->link);

                $filepath = '/videos';
                $file = $this->file('link');
                $filename = $this->link->hashName();
                File::streamUpload($filepath, $filename, $file, true);
                
                $data['link'] = $filename;
                $data['link_url'] = $filename;

                $this->upload_video($video , $video->link , 'link_id');
            }
        }

        $video->update($data);
    }
}
