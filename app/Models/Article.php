<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model implements TranslatableContract
{
    use HasFactory,Sluggable , Translatable ,SoftDeletes;

    public $translatedAttributes = ['title' , 'brief' , 'description'];

    protected $fillable = [
        'inner_image' , 'outer_image' , 'slug' , 'updated_by' , 'created_by'
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
                'source' => 'title'
            ]
        ];
    }

    public function courses()
    {
        return $this->hasMany(ArticleCourse::class);
    }

    public function products()
    {
        return $this->hasMany(ArticleProduct::class);
    }

    public function delete()
    {
        return parent::delete();
    }
}
