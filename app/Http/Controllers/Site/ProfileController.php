<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Order;
use App\Models\Product;
use App\Rules\IsValidPassword;
use App\Rules\MatchOldPassword;
use App\Traits\UploadImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    use UploadImage;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->guard('site')->user();

        return view('site.pages.profile.index' ,compact('user'));
    }

    /**
     * Display change password page.
     *
     * @return \Illuminate\Http\Response
     */
    public function password()
    {
        $user = auth()->guard('site')->user();

        return view('site.pages.profile.update_password' ,compact('user'));
    }

    /**
     * Display edit profile page
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user = auth()->guard('site')->user();

        return view('site.pages.profile.update_profile' ,compact('user'));
    }

    /**
     * update current logged in user data.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_profile(Request $request)
    {
        $validator = validator($request->all() , [
            'name' => ['required' , 'string' , 'max:255'],
            'phone' => ['required'],
            'email' => ['required' , 'string' , 'max:255' , 'email' , 'unique:users,email,'.auth()->guard('site')->id()],
            'image' => ['image' , 'max:2048' , 'mimes:png,jpg,jpeg']
        ] , [] ,[
            'name' => 'الإسم بالكامل',
            'phone' => 'رقم الهاتف',
            'email' => 'البريد الإلكتروني',
            'image' => 'الصوره الشخصيه'
        ]);

        if ($validator->fails()) {
            return failed_validation($validator->errors()->first());
        }

        $user = auth()->guard('site')->user();

        $data = $request->except('image');

        if ($request->image) {
            Storage::disk('s3.assets')->delete('assets/'.$user->image);

            $data['image'] = $this->upload_image($request->image , 'users' , 116 , 116);
        }

        try {
            $user->update($data);

            return response()->json('تم تحديث بيانات الملف الشخصي بنجاح' , 200);
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    /**
     * update current logged in user password.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_password(Request $request)
    {
        $validator = validator($request->all() , [
            'old_password' => ['required' , new MatchOldPassword],
            'password' => ['required' , new IsValidPassword , 'confirmed' ]
        ] ,[] ,[
            'old_password' => 'كلمة المرور القديمة',
            'password' => 'كلمة المرور الجديدة'
        ]);

        if ($validator->fails()) {
            return failed_validation($validator->errors()->first());
        }

        $user = auth()->guard('site')->user();

        try {
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            return response()->json('تم تحديث كلمة المرور بنجاح' , 200);
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    public function products()
    {
        $user = auth()->guard('site')->user();
        $ids = [];

        $orders = $user->orders()->where('user_subscribtion_id' , null)->where('status' , 'Done')->get(['order_details']);

        foreach ($orders as $order) {
            foreach (json_decode($order->order_details) as $detail) {
                if ($detail->associatedModel == 'product') {
                    array_push($ids , $detail->attributes->id);
                }
            }
            
        }

        $products = Product::all()->whereIn('id' , array_unique($ids));

        return view('site.pages.profile.products' ,compact('user' , 'products'));
    }

    public function courses()
    {
        $user = auth()->guard('site')->user();

        $ids = [];

        $orders = $user->orders()->where('user_subscribtion_id' , null)->where('status' , 'Done')->get(['order_details']);

        foreach ($orders as $order) {
            foreach (json_decode($order->order_details) as $detail) {
                if ($detail->associatedModel == 'course') {
                    array_push($ids , $detail->attributes->id);
                }
            }
            
        }

        $courses = Course::all()->whereIn('id' , array_unique($ids));

        return view('site.pages.profile.courses' ,compact('user' , 'courses'));
    }

    public function subscribtions()
    {
        $user = auth()->guard('site')->user();

        if ($user->subscribtion()->where('status', 'Done')->exists()){
            $subscribtion = $user->subscribtion()->where('status', 'Done')->first();
            if (! Carbon::now()->between($subscribtion->start_date , $subscribtion->end_date)) {
                $subscribtion->status = 'pending';
                $subscribtion->save();
            }
        }

        return view('site.pages.profile.subscribtions' ,compact('user'));
    }

    public function orders()
    {
        $user = auth()->guard('site')->user();

        return view('site.pages.profile.orders' ,compact('user'));
    }

    public function bill($id)
    {
        $order = Order::findOrFail($id);
        $payment = json_decode($order->payment_details);
        $total = isset($payment->payload)? $payment->payload['amount'] / 100: $payment->amount_cents / 100;
        $codeContents = "Client Name:".$order->user->name.";Tax Number:".$order->id.";Bill Date:".$order->created_at->format('d/m/Y').";Bill Total:".$total.";Tax:0";

        return view('site.pages.profile.bill' ,compact('order' , 'payment' , 'codeContents'));
    }
}
