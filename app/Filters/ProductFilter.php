<?php

namespace App\Filters;

class ProductFilter extends Filters
{
    protected $var_filters = ['categories', 'order'];

    public function categories($categories)
    {
        return $this->builder->whereIn('product_category_id' , $categories);
    }

    public function order($order)
    {
        switch ($order) {
            case 1:
                return $this->builder->orderByRaw('CONVERT(price , int) asc');
                break;
            case 2:
                return $this->builder->orderByRaw('CONVERT(price , int) desc');
                break;
            case 3:
                return $this->builder->orderBy('id' ,'desc');
                break;
            case 4:
                return $this->builder->orderBy('id' ,'desc');
                break;
            
            default:
                return $this->builder;
                break;
        }
    }
}