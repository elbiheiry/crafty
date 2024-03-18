<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleProduct extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'article_id' , 'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
