<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Course;
use App\Models\Package;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::all()->count();
        $packages = Package::all()->count();
        $articles = Article::all()->count();
        $free_courses = Course::all()->where('price' , null)->count();
        $paid_courses = Course::all()->where('price' , '!=', null)->count();

        return view('admin.pages.index' , compact('products' , 'packages' , 'articles' , 'free_courses' , 'paid_courses'));
    }
}
