<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id' , 'product_id'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
