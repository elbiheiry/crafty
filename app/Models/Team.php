<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
class Team extends Model implements TranslatableContract
{
    use HasFactory , Translatable , SoftDeletes;

    protected $fillable = [
        'image' , 'created_by' , 'updated_by'
    ];

    public $translatedAttributes = ['name' , 'position'];

    public function delete()
    {
        
        return parent::delete();
    }
}
