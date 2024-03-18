<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class Package extends Model implements TranslatableContract
{
    use HasFactory , Translatable , SoftDeletes;

    public $translatedAttributes = ['name'];

    protected $fillable = [
        'image' , 'price' , 'type' , 'updated_by' , 'created_by'
    ];

    public function get_type()
    {
        switch ($this->type) {
            case 'monthly':
                return 'شهريا';
                break;
            case 'annual':
                return 'سنويا';
                break;
            default:
                # code...
                break;
        }
    }

    public function active_subscribers()
    {
        return $this->hasMany(UserSubscribtion::class)->whereHas('order', function ($query) {
            $query->where('status','Done');
        });
    }

    public function inactive_subscribers()
    {
        return $this->hasMany(UserSubscribtion::class)->whereHas('order', function ($query) {
            $query->where('status' , '!=','Done');
        });
    }

    public function delete()
    {
        return parent::delete();
    }
}
