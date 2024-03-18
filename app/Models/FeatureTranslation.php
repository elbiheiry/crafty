<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeatureTranslation extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'title' , 'locale' , 'feature_id'
    ];
}
