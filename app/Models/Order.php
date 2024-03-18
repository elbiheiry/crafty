<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Pharaonic\Laravel\Audits\Auditable;

class Order extends Model
{
    use HasFactory , Auditable;

    protected $fillable = [
        'user_id' , 'user_subscribtion_id' , 'payment_details' ,'order_details' , 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getOrderDetailSequalizedAttribute()
    {
        return json_decode($this->order_details);
    }
}
