<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function index()
    {
        return view('admin.auth.reset');
    }

    public function send_mail(Request $request)
    {
        $validator = validator($request->all() , [
            'email' => ['required' , 'string' , 'max:225' , 'email' , 'exists:admins,email']
        ] ,[],[
            'email' => 'البريد الإلكتروني'
        ]);

        if ($validator->fails()) {
            return failed_validation($validator->errors()->first());
        }

        $email = $request->email;

        $admin = Admin::select('email')->where('email' , $email)->first();

        $admin->password = Str::random(8);

        Mail::to($admin->email)->send(new ResetPasswordMail($admin));

        return response()->json('تم إرسال رساله الي بريدك الإلكتروني' , 200);
    }

    public function edit_password($email)
    {
        return view('admin.auth.change-password' ,compact('email'));
    }

    public function change_password(Request $request , $email)
    {
        $validator = validator($request->all() , [
            'password' => ['required']
        ] ,[],[
            'password' => 'الرقم السري'
        ]);

        if ($validator->fails()) {
            return failed_validation($validator->errors()->first());
        }

        $admin = Admin::where('email' , $email)->firstOrFail();

        $admin->password = Hash::make($request->password);

        $admin->save();

        return response()->json(['message' => 'تم تغيير الرقم السري بنجاح برجاء تسجيل الدخول مرة اخري','url' => route('admin.login')], 200);
    }
}
