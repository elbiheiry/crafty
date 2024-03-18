<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trainer extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'name' , 'phone' , 'email' , 'age' , 'government' , 'city' , 'state' , 
        'previous_experience' , 'experience' , 'content' ,
        'qualification' , 'facebook' , 'youtube' , 'instagram' , 'cv'
    ];

    public function delete()
    {
        image_delete($this->cv , 'trainers');
        return parent::delete();
    }
}
