<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pharaonic\Laravel\Audits\Auditable;

class CourseCategory extends Model implements TranslatableContract
{
    use HasFactory,Sluggable , Translatable ,SoftDeletes , Auditable;

    public $translatedAttributes = ['name'];

    protected $fillable = [
        'image' , 'slug' , 'updated_by' , 'created_by' , 'deleted_by'
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

    public function courses()
    {
        return $this->hasMany(Course::class)->withTrashed();
    }
}
