<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductCategory extends Model implements TranslatableContract
{
    use HasFactory , Translatable , SoftDeletes;

    public $translatedAttributes = ['name'];

    protected $fillable = ['updated_by' , 'created_by'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function delete()
    {
        return parent::delete();
    }
}
