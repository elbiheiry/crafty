<?php

namespace App\Http\Requests;

use App\Models\Team;
use App\Traits\UploadImage;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
class TeamRequest extends FormRequest
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
            'position' => ['required' , 'string' , 'max:255']
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
            'position' => ['required' , 'string' , 'max:255']
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
            'image' => 'صورة العضو',
            'name' => 'إسم العضو',
            'position' => 'وظيفة العضو'
        ];
    }

    public function store()
    {
        $data = [
            'en' => ['name' => $this->name , 'position' => $this->position],
            'ar' => ['name' => $this->name , 'position' => $this->position],
            'image' => $this->upload_image($this->image , 'team' , 170 , 170),
            'created_at' => auth()->id()
        ];

        Team::create($data);
    }

    public function update($team)
    {
        $data = [
            'en' => ['name' => $this->name , 'position' => $this->position],
            'ar' => ['name' => $this->name , 'position' => $this->position],
            'updated_at' => auth()->id()
        ];

        if ($this->image) {
            Storage::disk('s3.assets')->delete('assets/'.$team->image);
            $data['image'] = $this->upload_image($this->image , 'team' , 170 , 170);
        }

        $team->update($data);
    }
}
