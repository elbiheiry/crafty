<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaqCategoryTranslation extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'name' , 'faq_category_id' , 'locale'
    ];
}
