<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class MembershipBenefit extends Model implements TranslatableContract
{
    use HasFactory , SoftDeletes , Translatable;

    public $translatedAttributes = ['title' , 'description'];

    protected $fillable = ['updated_by' , 'created_by'];
}
