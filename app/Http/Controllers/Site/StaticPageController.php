<?php

namespace App\Http\Controllers\Site;

use App\Models\Faq;
use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Article;
use App\Models\ArticleCourse;
use App\Models\ArticleProduct;
use App\Models\ArticleProductCourse;
use App\Models\Company;
use App\Models\CompanyGallery;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\FaqCategory;
use App\Models\Feature;
use App\Models\Investor;
use App\Models\MembershipBenefit;
use App\Models\Message;
use App\Models\Order;
use App\Models\Package;
use App\Models\Product;
use App\Models\Subscriber;
use App\Models\Team;
use App\Models\Trainer;
use App\Models\UserSubscribtion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    /**
     * Show faq page.
     *
     * @return \Illuminate\Http\Response
     */
    public function faqs()
    {
        $categories = FaqCategory::all();

        return view('site.pages.static.faqs' ,compact('categories'));
    }

    /**
     * Show privacy policy page.
     *
     * @return \Illuminate\Http\Response
     */
    public function privacy()
    {
        return view('site.pages.static.privacy');
    }

    /**
     * Show terms and conditions page.
     *
     * @return \Illuminate\Http\Response
     */
    public function terms()
    {
        return view('site.pages.static.terms');
    }

    /**
     * Show blog page.
     *
     * @return \Illuminate\Http\Response
     */
    public function blog(Request $request)
    {
        $articles = Article::orderBy('id' , 'desc')->paginate(4);

        if ($request->ajax()) {
            $articles = Article::orderBy( 'id', 'DESC' )->paginate( 4, [ '*' ], 'page', request()->page );

            return view( 'site.pages.static.templates.articles', compact( 'articles' ) );
        }

        return view('site.pages.static.blog' ,compact('articles'));
    }

    /**
     * Show single article page.
     *
     * @return \Illuminate\Http\Response
     */
    public function article($id , $slug)
    {
        $article = Article::findOrFail($id);

        $related_articles = Article::all()->where('id' , '!=' , $id)->take(4)->sortByDesc('id');

        $words = explode(" " , $article->translate(app()->getLocale())->title);

        $products = ArticleProduct::all()->where('article_id' , $article->id);
        $courses = ArticleCourse::all()->where('article_id' , $article->id);

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

        return view('site.pages.static.article' ,compact('article' , 'related_articles' , 'products' , 'courses' , 'course_ids'));
    }

    /**
     * return content us page
     *
     * @return \Illuminate\Http\Response
     */
    public function contact_us()
    {
        return view('site.pages.static.contact');
    }

    /**
     * store messages in contact us
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store_message(Request $request)
    {
        $validator = validator($request->all() , [
            'name' => ['required' , 'string' , 'max:255'],
            'phone' => ['required'],
            'subject' => ['required' , 'string' , 'max:255'],
            'message' => ['required']
        ] ,[] ,[
            'name' => 'الأسم بالكامل',
            'phone' => 'رقم الهاتف',
            'subject' => 'عنوان الرسالة',
            'message' => 'الرسالة'
        ]);

        if ($validator->fails()) {
            return failed_validation($validator->errors()->first());
        }

        try {
            Message::create($request->all());

            return response()->json( 'تم إرسال رسالتك بنجاح وسيتم التواصل معك في أقرب وقت ممكن', 200);
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    /**
     * return about us page
     *
     * @return \Illuminate\Http\Response
     */
    public function about_us()
    {
        $about = About::firstOrFail();
        $features = Feature::all();
        $members = Team::all()->sortByDesc('id');
        $investors = Investor::all()->sortByDesc('id');
        $articles = Article::all()->sortByDesc('id')->take(6);

        return view('site.pages.static.about' ,compact('about' , 'features' , 'members' , 'articles' , 'investors'));
    }

    /**
     * return Institutions and companies page
     *
     * @return \Illuminate\Http\Response
     */
    public function companies()
    {
        $images = CompanyGallery::all()->sortByDesc('id');

        return view('site.pages.static.company' ,compact('images'));
    }

    /**
     * Store new company 
     *
     * @return \Illuminate\Http\Response
     */
    public function company_store(Request $request)
    {
        $validator = validator($request->all() , [
            'name' => ['required' , 'string' , 'max:255'],
            'company_name' => ['required' , 'string' , 'max:255'],
            'phone' => ['required'],
            'email' => ['required' , 'email' , 'string' , 'max:255'],
            'no_of_employees' => ['required'],
            'description' => ['required']
        ] , [] , [
            'name' => 'الاسم بالكامل',
            'company_name' => 'اسم الشركة أو المؤسسة',
            'phone' => 'رقم الهاتف',
            'email' => 'البريد الألكترونى',
            'no_of_employees' => 'عدد الموظفين',
            'description' => 'أخبرنا عن شركتك أو مؤسستك'
        ]);

        if ($validator->fails()) {
            return failed_validation($validator->errors()->first());
        }

        try {
            Company::create($request->all());

            return response()->json( 'تم إرسال رسالتك بنجاح وسيتم التواصل معك في أقرب وقت ممكن', 200);
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    /**
     * return sign as a trainer page
     *
     * @return \Illuminate\Http\Response
     */
    public function trainers()
    {
        return view('site.pages.static.trainers');
    }

    /**
     * Store new trainer
     *
     * @return \Illuminate\Http\Response
     */
    public function store_trainer(Request $request)
    {
        $validator = validator($request->all() , [
            'name' => ['required' , 'string' , 'max:255'],
            'phone' => ['required'],
            'email' => ['required' , 'email' , 'string' , 'max:255'],
            'age' => ['required' , 'numeric'],
            'government' => ['required' , 'string' , 'max:255'],
            'city' => ['required' , 'string' , 'max:255'],
            'state' => ['required' , 'string' , 'max:255'],
            'previous_experience' => ['required'],
            'experience' => $request->previous_experience == 'yes' ? ['required'] : '',
            'content' => ['required'],
            'qualification' => ['required' , 'string' , 'max:255'],
            'cv' => ['required' , 'max:2048' , 'mimes:pdf,doc,docx']
        ] , [] , [
            'name' => 'الاسم بالكامل',
            'phone' => 'رقم الهاتف',
            'email' => 'البريد الألكترونى',
            'age' => 'السن',
            'government' => 'المحافظة',
            'city' => 'المدينة أو المركز',
            'state' => 'القرية أو المنطقة',
            'previous_experience' => 'هل سبق لك تنفيذ دورات تدريبية',
            'experience' => 'اذكر الدورات وأماكن التدريب',
            'content' => 'المحتوى الذى تود تقديم دورات تدريبية فيه ',
            'qualification' => 'المؤهل العلمى',
            'cv' => 'السيرة الذاتية'
        ]);

        if ($validator->fails()) {
            return failed_validation($validator->errors()->first());
        }

        $data = $request->all();

        $data['cv'] = $request->cv->hashName();

        try {
            $request->cv->store('trainers' , 'public');

            Trainer::create($data);

            return response()->json( 'تم إرسال رسالتك بنجاح وسيتم التواصل معك في أقرب وقت ممكن', 200);
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    /**
     * return packages page
     *
     * @return \Illuminate\Http\Response
     */
    public function packages()
    {
        $packages = Package::all();
        $benefits = MembershipBenefit::all();
        $categories = CourseCategory::all();

        return view('site.pages.static.packages' ,compact('packages' , 'benefits' ,'categories'));
    }

    public function subscribe_to_package($id)
    {
        if (auth()->guard('site')->guest()) {
            return response()->json( 'يجب تسجيل الدخول اولا ', 400);
        }

        $package = Package::findOrFail($id);

        $country = "EG";
        
        $amount= [
            "total"=> $package->price * 100,
            "currency"=> 'EGP',
        ];
        
        $subscribe = UserSubscribtion::where('user_id' , auth()->guard('site')->id())->first();

        if ($subscribe) {
            if($subscribe->package_id == $id){
                if (Carbon::now()->format('d-m-Y') <= Carbon::parse($subscribe->end_date)->format('d-m-Y')) {
                    return response()->json('الباقة الحاليه مازالت سارية ' , 400);
                }
            }else{
                $subscribe->start_date = Carbon::now();
                $subscribe->end_date = $package->type == 'monthly' ? Carbon::now()->addDays(30) : Carbon::now()->addYear();
                $subscribe->status  = 'pending';

                $subscribe->save();
            }
            
        }else{
            $subscribe = UserSubscribtion::create([
                'package_id' => $id,
                'user_id' => auth()->guard('site')->id(),
                'start_date' => Carbon::now(),
                'end_date' => $package->type == 'monthly' ? Carbon::now()->addDays(30) : Carbon::now()->addYear(),
                'status' => 'pending'
            ]);
        }

        $order = Order::create([
            'user_id' => auth()->guard('site')->id(),
            'user_subscribtion_id' => $subscribe->id,
            'order_details' => json_encode($subscribe),
            'status' => 'pending'
        ]);

        $reference = $order->id;

        $productList= [
            [
                "productId" => $subscribe->id,
                "name" => $package->translate('ar')->name,
                "description" => "إشتراك موقع كرافتي في  ". $package->translate('ar')->name,
                "price" => $package->price * 100,
                "quantity" => 1
            ]
        ];
        
        $returnUrl  = route('site.checkout.return');
        $callbackUrl  = route('site.checkout.success');
        $cancelUrl  = route('site.checkout.cancel');

        $httpClient = new \GuzzleHttp\Client(); // guzzle 6.3
        $response = $httpClient->request('POST', 'https://sandboxapi.opaycheckout.com/api/v1/international/cashier/create', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept'       => 'application/json',
                        'Authorization' => 'Bearer OPAYPUB16450149351960.03643818418074518',
                        'MerchantId' => '281822021641960'
                    ],
                    'body' => json_encode( [
                                    'country' => $country,
                                    'reference' => $reference,
                                    'amount' => $amount,
                                    'productList' => $productList,
                                    'returnUrl' => $returnUrl,
                                    'callbackUrl'=> $callbackUrl,
                                    'cancelUrl' => $cancelUrl,
                                ] , true)
        ]);
        $response = json_decode($response->getBody()->getContents(), true);

        return response()->json($response['data']['cashierUrl'] , 200);
    }
}