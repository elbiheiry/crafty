<?php

namespace App\Filters;

class CourseFilter extends Filters
{
    protected $var_filters = ['levels', 'order'];

    public function levels($levels)
    {
        return $this->builder->whereIn('level' , $levels);
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