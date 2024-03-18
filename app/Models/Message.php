<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pharaonic\Laravel\Audits\Auditable;

class Message extends Model
{
    use HasFactory ,SoftDeletes , Auditable;

    protected $fillable = [
        'name' , 'phone' , 'message' , 'subject' , 'created_by' , 'updated_by' , 'deleted_by'
    ];
}
