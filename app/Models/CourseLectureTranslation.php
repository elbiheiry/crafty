<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseLectureTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name' , 'course_lecture_id' , 'locale'
    ];
}
