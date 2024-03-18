<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CompanyGallery extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['image' , 'created_by' , 'updated_by'];

    public function delete()
    {
        return parent::delete();
    }
}
