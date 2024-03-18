<?php

namespace App\Traits;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

trait UploadImage 
{
    public $filepath = '/assets';

    public function upload_image($image , $folder , $width = null, $height = null)
    {
        if(!$image->extension() == 'svg'){
            $image->store($folder ,'public');
            $name = $image->hashName();
            Image::make(storage_path('app/public/'.$folder .'/'.$name))
                    ->resize($width , $height)
                    ->save(storage_path('app/public/' .$folder .'/'.$name));

            $file = fopen(storage_path('app/public/' .$folder .'/'.$name) , 'r+');

            File::fileUpload($this->filepath, $name, $file, true);
            Storage::disk('s3.assets')->setVisibility('assets/'.$name , 'public');
            image_delete($name , 'users');
            
        }else{
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = storage_path('app/public/'.$folder);
            $image->move($destinationPath, $name);

            $file = fopen(storage_path('app/public/' .$folder .'/'.$name) , 'r+');

            File::fileUpload($this->filepath, $name, $file, true);
            Storage::disk('s3.assets')->setVisibility('assets/'.$name , 'public');
            image_delete($name , 'users');
        }

        return $name;
    }
}