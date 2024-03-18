<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscribtion extends Model
{
    use HasFactory;

    protected $fillable = ['user_id' , 'package_id' ,'start_date' , 'end_date' ,'status'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class , 'user_subscribtion_id');
    }

    public function return_status()
    {
        if ($this->status == 'Done' || Carbon::now()->between($this->start_date , $this->end_date)) {
            return 'مفعل';
        }else{
            return 'غير مفعل';
        }
    }
}
