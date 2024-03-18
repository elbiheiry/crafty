<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
class Feature extends Model implements TranslatableContract
{
    use HasFactory , Translatable , SoftDeletes;

    protected $fillable = [
        'image' , 'updated_by' , 'created_by'
    ];

    public $translatedAttributes = ['title'];

    public function delete()
    {
        return parent::delete();
    }
}
