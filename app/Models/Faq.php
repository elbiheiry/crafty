<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
class Faq extends Model implements TranslatableContract
{
    use HasFactory , Translatable , SoftDeletes;

    public $translatedAttributes = ['question' , 'answer'];

    protected $fillable = ['updated_by' , 'order' , 'faq_category_id' , 'created_by'];

    public function category()
    {
        return $this->belongsTo(FaqCategory::class ,'faq_category_id' , 'id');
    }
}
