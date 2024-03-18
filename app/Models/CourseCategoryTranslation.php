<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCategoryTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['name' , 'locale' , 'course_category_id'];
}
