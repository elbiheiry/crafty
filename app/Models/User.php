<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Response;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , SoftDeletes;

    protected $guard = 'site';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'age',
        'country',
        'city',
        'image',
        'address',
        'facebook',
        'instagram',
        'password',
        'provider_id',
        'provider',
        'access_token'
    ];

    /**
     * return user image from gravatar
     *
     * @return Response
     */
    public function user_image()
    {
        if (!$this->image) {
            $hash = md5(strtolower(trim($this->email)));
            $image = 'http://www.gravatar.com/avatar/'.$hash;
        }else{
            $image = Storage::disk('s3.assets')->temporaryUrl('assets/' . $this->image, \Carbon\Carbon::now()->addMinutes(120));
        }

        return $image;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function product_wishlists()
    {
        return $this->hasMany(ProductWishlist::class);
    }

    public function course_wishlists()
    {
        return $this->hasMany(CourseWishlist::class);
    }

    public function comments()
    {
        return $this->hasMany(CourseComment::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function subscribtion()
    {
        return $this->hasOne(UserSubscribtion::class);
    }
}
