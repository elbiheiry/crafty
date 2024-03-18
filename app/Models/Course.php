<?php

namespace App\Models;

use App\Filters\CourseFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Meema\MediaConverter\Traits\Convertable;
use Pharaonic\Laravel\Audits\Auditable;

class Course extends Model implements TranslatableContract
{
    use HasFactory,Sluggable , Translatable ,SoftDeletes , Auditable ,Convertable;

    public $translatedAttributes = [
        'name' , 'lecturer_name' , 'lecturer_speciality' ,
        'description' , 'requirements' ,'advantages'
    ];

    protected $fillable = [
        'image' , 'slug' , 'views' , 'price' ,
        'discount' ,'lecturer_image' ,'level' ,
        'course_category_id' , 'video' , 'video_url' , 'updated_by',
        'created_by' , 'deleted_by' , 'video_id'
    ];

    /**
     * create slug input 
     *
     * @return response
     */
    public function sluggable() :Array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function category()
    {
        return $this->belongsTo(CourseCategory::class , 'course_category_id' , 'id');
    }

    public function lectures()
    {
        return $this->hasMany(CourseLecture::class);
    }

    public function products()
    {
        return $this->hasMany(CourseProduct::class);
    }

    public function get_level()
    {
        switch ($this->level) {
            case '1':
                return 'مبتدئ';
                break;
            case '2':
                return 'متوسط';
                break;
            case '3':
                return 'محترف';
                break;
            
            default:
                break;
        }
    }

    public function increase_views()
    {
        return $this->views++;
    }

    public function price_after_discount()
    {
        if ($this->discount) {
            return $this->price - ($this->price * $this->discount / 100);
        }else{
            return $this->price;
        }
    }

    public function comments()
    {
        return $this->hasMany(CourseComment::class);
    }

    public function get_videos_counter()
    {
        $counter = 0;
        foreach ($this->lectures() as $lecture) {
            foreach ($lecture->videos() as $video) {
                $counter++;
            }
        }

        return $counter;
    }

    public function scopeFilter($query,CourseFilter $filter)
    {
        return $filter->apply($query);
    }

}
