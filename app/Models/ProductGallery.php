<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductGallery extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['image' , 'product_id' , 'updated_by' , 'created_by'];

    public function delete()
    {
        
        return parent::delete();
    }
}
