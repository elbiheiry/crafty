<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pharaonic\Laravel\Audits\Auditable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class CourseLectureVideo extends Model implements TranslatableContract
{
    use HasFactory ,Translatable ,SoftDeletes ,Auditable;

    public $translatedAttributes = [
        'name'
    ];

    protected $fillable = [
        'course_lecture_id' , 'updated_by',
        'created_by' , 'deleted_by' , 'link' ,'link_url' , 'link_id'
    ];

    public function course_lecture()
    {
        return $this->belongsTo(CourseLecture::class);
    }
}
