<?php

namespace App\Http\Controllers\Site;

use App\Filters\CourseFilter;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseComment;
use App\Models\Coursecourse;
use App\Models\CourseLectureVideo;
use App\Models\CourseProduct;
use App\Models\CourseWishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Aws\MediaConvert\MediaConvertClient;  
use Aws\Exception\AwsException;

class CourseController extends Controller
{
    /**
     * show index page
     *
     * @param CourseFilter $filter
     * @param CourseCategory $id
     * @param CourseCategory $slug
     * @return Illuminate\Http\Response
     */
    public function index(CourseFilter $filter , $id = null , $slug = null)
    {
        if($id){
            $courses = Course::filter($filter)->where('course_category_id' , $id)->where('price' ,'!=' , null)->get();
            $category = CourseCategory::findOrFail($id);
        }else{
            $courses = Course::filter($filter)->where('price' ,'!=' , null)->get();
            $category = null;
        }

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


        if (request()->ajax()) {
            if($id){
                $courses = Course::filter($filter)->where('course_category_id' , $id)->where('price' ,'!=' , null)->get();
            }else{
                $courses = Course::filter($filter)->where('price' ,'!=' , null)->get();
            }

            return view( 'site.pages.courses.templates.courses', compact( 'courses' ) );
        }

        return view('site.pages.courses.index' ,compact('courses' , 'category' , 'course_ids'));
    }

    /**
     * show free-courses page
     *
     * @param CourseFilter $filter
     * @return Illuminate\Http\Response
     */
    public function free_courses(CourseFilter $filter)
    {
        $courses = Course::filter($filter)->where('price' , null)->get();
        if (request()->ajax()) {
            $courses = Course::filter($filter)->where('price' , null)->get();
            
            return view( 'site.pages.courses.templates.free_courses', compact( 'courses' ) );
        }

        return view('site.pages.courses.free' ,compact('courses'));
    }

    /**
     * Show single course page.
     *
     * @param int $id
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function course($id , $slug)
    {
        $course = Course::findOrFail($id);
        $course->increase_views();
        $course->save();

        $related_courses = Course::all()->sortByDesc('id')->take(6)->where('course_category_id' , $course->course_category_id)->where('id' , '!=' , $id);
        $products = CourseProduct::all()->sortByDesc('id')->where('product_id' , $id);

        $video_status = 'no';
        if ($course->price) {
            $video = explode('.', $course->video);
            $course->video_url = config('filesystems.disks.s3.videos.url') . '/outputs/' . $video[0] . '.m3u8';
            $mediaConvertClient = new MediaConvertClient([
                'version' => 'latest',
                'region' => env('AWS_DEFAULT_REGION'),
                // 'profile' => 'default',
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
                'endpoint' => 'https://q25wbt2lc.mediaconvert.us-east-1.amazonaws.com'
            ]);

            if ($course->video_id) {
                $result = $mediaConvertClient->getJob([
                    'Id' => $course->video_id,
                ]);
        
                $video_status = $result['Job']['Status'] === 'PROGRESSING' ? 'no' : 'yes';
            }else{
                $video_status = 'no';
            }
        }
        $course_ids = [];
        $status = 'pending';
        if (auth()->guard('site')->check()) {
            $orders = auth()->guard('site')->user()->orders()->where('user_subscribtion_id' , null)->where('status' , 'Done')->get(['order_details']);
            foreach ($orders as $order) {
                foreach (json_decode($order->order_details) as $detail) {
                    if ($detail->associatedModel == 'course') {
                        array_push($course_ids , $detail->attributes->id);
                    }
                }
            }
            if(auth()->guard('site')->user()->subscribtion()->whereDate('start_date' , '<=' , \Carbon\Carbon::now())->whereDate('end_date' , '>=' , \Carbon\Carbon::now())->where('status' , 'Done')->count() > 0){
                $status = 'Done';
            }
        }

        return view('site.pages.courses.course' , compact('course' , 'related_courses' , 'products' , 'course_ids' , 'status' , 'video_status'));
    }

    public function video($id)
    {
        $video = CourseLectureVideo::findOrFail($id);

        $latest = explode('.', $video->link);

        $video->link_url = config('filesystems.disks.s3.videos.url') . '/outputs/' . $latest[0] . '.m3u8';

        $mediaConvertClient = new MediaConvertClient([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION'),
            // 'profile' => 'default',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
            'endpoint' => 'https://q25wbt2lc.mediaconvert.us-east-1.amazonaws.com'
        ]);

        if ($video->link_id) {
            $result = $mediaConvertClient->getJob([
                'Id' => $video->link_id
            ]);
    
            $link_status = $result['Job']['Status'] === 'PROGRESSING' ? 'no' : 'yes';
        }else{
            $link_status = 'no';
        }

        return view('site.pages.courses.templates.video' , compact('video' , 'link_status'));
    }

    /**
     * send comment about lecture
     *
     * @param Request $request
     * @param Course $id
     * @return Response
     */
    public function send_comment(Request $request , $id)
    {
        $validator = validator($request->all() , [
            'lecture_id' => ['not_in:0'],
            'comment' => ['required']
        ] , [] ,[
            'lecture_id' => 'إختر المحاضره',
            'comment' => 'السؤال'
        ]);

        if ($validator->fails()) {
            return failed_validation($validator->errors()->first());
        }

        try {
            CourseComment::create([
                'course_id' => $id,
                'course_lecture_id' => $request->lecture_id,
                'user_id' => auth()->guard('site')->id() , 
                'comment' => $request->comment
            ]);

            return response()->json( 'تم إرسال سؤالك بنجاح وسيتم التواصل معك في اقرب وقت ممكن', 200);
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    /**
     * add product to wishlist
     *
     * @param Request $request
     * @param Course $id
     * @return Response
     */
    public function wishlist(Request $request , $id)
    {
        $user = auth()->guard('site')->user();

        if (auth()->guard('site')->guest()) {
            return failed_validation('برجاء تسجيل الدخول اولا ' , 400);
        }

        if ($user->course_wishlists()->where('course_id' , $id)->first()) {
            return failed_validation('هذه الدوره مضافه بالفعل لقائمة الادوات المفضله' , 400);
        }else{
            try {
                $user->course_wishlists()->create([
                    'course_id' => $id
                ]);

                return response()->json( 'تم إضافة هذه الدوره لقائمه المفضله لديك ', 200);
            } catch (\Throwable $th) {
                return error_response();
            }
        }
    }

    /**
     * remove product from wishlist
     *
     * @param Product $id
     * @return Response
     */
    public function remove_from_wishlist($id)
    {
        CourseWishlist::findOrFail($id)->delete();

        return redirect()->back();
    }

    /**
     * add products to cart
     *
     * @param Request $request
     * @param Product $id
     * @return Response
     */
    public function add_to_cart(Request $request , $id)
    {
        $course = Course::findOrFail($id);
        $quantity = $request->quantity;
        $item = \Cart::get($id.'+course');

        // dd($id);

        try {
            if ($item != null){
                return response()->json('هذه الدوره مضافه بالفعل' ,400);
            }else{
                \Cart::add([
                    'id' => $id.'+course',
                    'name' => $course->translate(app()->getLocale())->name,
                    'quantity' => $quantity ? $quantity : 1,
                    'price' => $course->price_after_discount(),
                    'associatedModel' => 'course',
                    'attributes' => [
                        'id' => $course->id,
                        'image' => $course->image,
                        'lecturer_image' => $course->lecturer_image,
                        'lecturer_name' => $course->translate(app()->getLocale())->lecturer_name,
                        'views' => $course->views,
                        'category_name' => $course->category->translate(app()->getLocale())->name,
                        'level' => $course->get_level(),
                        'slug' => $course->slug
                    ]
                ]);
                return response()->json([
                    'message' => 'تم إضافه الدوره لسلة المشتريات بنجاح',
                    'counter' => \Cart::getContent()->count()
                ] ,200);
            }
            
        } catch (\Throwable $th) {
            return error_response();
        }
    }
}
