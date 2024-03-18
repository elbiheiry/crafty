<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleCourse extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'article_id' , 'course_id'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}