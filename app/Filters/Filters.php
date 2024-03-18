<?php
/**
 * Created by PhpStorm.
 * User: computec
 * Date: 12/7/2020
 * Time: 6:26 PM
 */

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    public $request;

    protected $var_filters = [];

    protected $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;
        foreach ($this->getFilterAttr() as $name=>$value)
        {
            if (method_exists($this,$name))
            {
                $this->$name($value);
            }
        }
        return $this->builder;
    }

    public function getFilterAttr()
    {
        return array_filter($this->request->only($this->var_filters));
    }
}