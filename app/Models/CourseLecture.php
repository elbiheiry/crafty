<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pharaonic\Laravel\Audits\Auditable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class CourseLecture extends Model implements TranslatableContract
{
    use HasFactory ,Translatable ,SoftDeletes ,Auditable;

    public $translatedAttributes = [
        'name'
    ];

    protected $fillable = [
        'course_id' , 'updated_by',
        'created_by' , 'deleted_by'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function videos()
    {
        return $this->hasMany(CourseLectureVideo::class);
    }

    public function comments()
    {
        return $this->hasMany(CourseComment::class);
    }
}
