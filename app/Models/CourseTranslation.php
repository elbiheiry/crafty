<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name' , 'lecturer_name' , 'lecturer_speciality' ,
        'description' , 'requirements' ,'advantages' ,'locale' , 'course_id'
    ];
}
