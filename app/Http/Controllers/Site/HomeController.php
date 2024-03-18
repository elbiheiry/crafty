<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Course;
use App\Models\Product;
use App\Models\Subscriber;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * show home page
     *
     * @return Response
     */
    public function index()
    {
        $products = Product::all()->sortByDesc('id')->take(6);
        $articles = Article::all()->sortByDesc('id')->take(4);
        $courses = Course::all()->sortByDesc('id')->take(9)->where('price' , '!=' ,null);

        $course_ids = [];
        if (auth()->guard('site')->check()) {
            

            $orders = auth()->guard('site')->user()->orders()->where('user_subscribtion_id' , null)->where('status' , 'Done')->get(['order_details']);

            foreach ($orders as $order) {
                foreach (json_decode($order->order_details) as $detail) {
                    if ($detail->associatedModel == 'course') {
                        array_push($course_ids , $detail->attributes->id);
                    }
                }
                
            }
        }

        return view('site.pages.index' ,compact('products' , 'articles' , 'courses' , 'course_ids'));
    }

    /**
     * add users to newsletter
     *
     * @param Request $request
     * @return Response
     */
    public function subscribe(Request $request)
    {
        $validator = validator($request->all() , [
            'email' => ['required' , 'string' , 'max:255' , 'unique:subscribers,email']
        ] ,[]);

        if ($validator->fails()) {
            return failed_validation($validator->errors()->first());
        }

        try {
            Subscriber::create($request->all());

            return response()->json( 'تمت إضافتك للنشره الإخباريه بنجاح', 200);
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    public function search(Request $request)
    {
        $search = $request->search;

        $courses = Course::whereTranslationLike('name' , '%'.$search.'%')->orderBy('id' , 'desc')->get();
        $products = Product::whereTranslationLike('name' , '%'.$search.'%')->orderBy('id' , 'desc')->get();

        $course_ids = [];
        if (auth()->guard('site')->check()) {
            

            $orders = auth()->guard('site')->user()->orders()->where('user_subscribtion_id' , null)->where('status' , 'Done')->get(['order_details']);

            foreach ($orders as $order) {
                foreach (json_decode($order->order_details) as $detail) {
                    if ($detail->associatedModel == 'course') {
                        array_push($course_ids , $detail->attributes->id);
                    }
                }
                
            }
        }

        return view('site.pages.static.search' ,compact('courses' , 'products' ,'search' , 'course_ids'));
    }
}
