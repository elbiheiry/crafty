<?php 

use Intervention\Image\Facades\Image;

if (!function_exists('image_manipulate')) {
    function image_manipulate($image, $path, $width = null, $height = null)
    {

        $image->store($path ,'public');
        $name = $image->hashName();

        if(!$image->extension() == 'svg'){
            if ($width && $height) {
                Image::make(storage_path('app/public/' . $path . '/' . $name))
                    ->resize($width, $height)
                    ->save(storage_path('app/public/' . $path . '/' . $name));
            }

            if ($width && $height == null) {
                Image::make(storage_path('app/public/' . $path . '/' . $name))
                    ->resize($width, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(storage_path('app/public/' . $path . '/' . $name));
            }

            if ($height && $width == null) {
                Image::make(storage_path('app/public/' . $path . '/' . $name))
                    ->resize(null, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(storage_path('app/public/' . $path . '/' . $name));
            }
        }else{
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = storage_path('app/public/'.$path);
            $image->move($destinationPath, $name);
        }
        
        return $name;
    }
}

if (!function_exists('image_delete')) {
    function image_delete($image, $path)
    {
        @unlink(storage_path('app/public/'.$path.'/'.$image));
    }
}

if (!function_exists('get_image')) {
    function get_image($image, $path)
    {
        $image = url(('storage/app/public/'.$path.'/'.$image));

        return $image;
    }
}

if (!function_exists('failed_validation')) {
    function failed_validation($error)
    {
        return response()->json($error , 400);;
    }
}

if (!function_exists('add_response')) {
    function add_response()
    {
        return response()->json('تم إضافه البيانات بنجاح' , 200);;
    }
}

if (!function_exists('update_response')) {
    function update_response()
    {
        return response()->json('تم تحديث البيانات بنجاح' , 200);;
    }
}

if (!function_exists('error_response')) {
    function error_response()
    {
        return response()->json('خطأ برجاء إعاده المحاوله مره اخري' , 400);;
    }
}