<?php

namespace App\Http\Controllers\Site\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $providers = [
        'facebook','google'
    ];

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:site')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('site.auth.login');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string|min:8',
        ] ,[

        ],[
            $this->username() => 'البريد الإلكتروني',
            'password' => 'الرقم السري '
        ]);
    }


    public function logout(Request $request)
    {
       $this->guard()->logout();
    //    $request->session()->flush();
    //    $request->session()->regenerate();
       return redirect('/');    
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('site');
    }

    /**
     * Redirect the user to the Twitter authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from Twitter.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();
        
        $authUser = $this->findOrCreateUser($user, $provider);

        Auth::guard('site')->login($authUser, true);
        return redirect('/');
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  Member
     */
    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->orWhere('email' , $user->email)->first();

        if ($authUser) {
            return $authUser;
        }
        return User::create([
            'name' => $user->name,
            'email' => $user->email,
            'password' => Hash::make($provider),
            'provider' => $provider,
            'provider_id' => $user->id
        ]);
    }

    public function facebook_login(Request $request , $provider)
    {
        $data = $request->all();

        $member = User::where('provider_id' , $data['id'])->orWhere('email' , $data['email'])->first();

        if ($member) {
            auth()->guard('site')->login($member , $request->has('remember'));
        }else{
            $name = $data['first_name'].' '.$data['last_name'];

            $member = User::create([
                'name' => $name,
                'email' => $data['email'],
                'password' => Hash::make($provider),
                'provider' => $provider,
                'provider_id' => $data['id']
            ]);
            
            if ($member) {
                auth()->guard('site')->login($member , $request->has('remember'));
            }
        }

        return response()->json('تم تسجيل الدخول بنجاح', 200);
    }
}
