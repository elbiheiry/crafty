<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class Setting extends Model implements TranslatableContract
{
    use HasFactory , Translatable;

    protected $fillable = [
        'email' , 'phone' , 'map' , 'updated_by' , 'created_by'
    ];

    public $translatedAttributes = ['terms' , 'privacy'];
}
