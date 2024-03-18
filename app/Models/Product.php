<?php

namespace App\Models;

use App\Filters\ProductFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
class Product extends Model implements TranslatableContract
{
    use HasFactory,Sluggable , Translatable ,SoftDeletes;

    public $translatedAttributes = ['name' , 'description'];

    protected $fillable = [
        'image' , 'product_category_id' , 'slug' , 'price' , 'quantity', 'updated_by' , 'created_by'
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
                'source' => 'name_en'
            ]
        ];
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class , 'product_category_id' , 'id');
    }

    public function images()
    {
        return $this->hasMany(ProductGallery::class);
    }

    public function wishlists()
    {
        return $this->hasMany(ProductWishlist::class);
    }

    public function scopeFilter($query,ProductFilter $filter)
    {
        return $filter->apply($query);
    }

    public function delete()
    {
        return parent::delete();
    }
}
