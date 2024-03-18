<?php

use App\Http\Controllers\Site\Auth\ForgotPasswordController;
use App\Http\Controllers\Site\Auth\LoginController;
use App\Http\Controllers\Site\Auth\RegisterController;
use App\Http\Controllers\Site\Auth\ResetPasswordController;
use App\Http\Controllers\Site\CartController;
use App\Http\Controllers\Site\CheckoutController;
use App\Http\Controllers\Site\CourseController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\ProductController;
use App\Http\Controllers\Site\ProfileController;
use App\Http\Controllers\Site\StaticPageController;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name('site.')->group(function (){
     // Authentication Routes...
     Route::get('login', [LoginController::class , 'showLoginForm'])->name('login');
     Route::post('login', [LoginController::class , 'login']);
     Route::post('logout', [LoginController::class , 'logout'])->name('logout');

     // Registration Routes...
     Route::get('register', [RegisterController::class , 'showRegistrationForm'])->name('register');
     Route::post('register', [RegisterController::class , 'register']);

     // Password Reset Routes...
     Route::get('password/reset', [ForgotPasswordController::class , 'showLinkRequestForm'])->name('password.request');
     Route::post('password/email', [ForgotPasswordController::class , 'sendResetLinkEmail'])->name('password.email');
     Route::get('password/reset/{token}', [ResetPasswordController::class , 'showResetForm'])->name('password.reset');
     Route::post('password/reset', [ResetPasswordController::class , 'reset'])->name('password.update');

     //social login routes..
     Route::post('/facebook-login/{provider}' , [LoginController::class , 'facebook_login'])->name('login.facebook');
     Route::get('/social-login//{provider}', [LoginController::class , 'redirectToProvider'])->name('login.redirect');
     Route::get('/social-login/{provider}/callback', [LoginController::class , 'handleProviderCallback'])->name('login.callback');

    //home page route
    Route::get('/' , [HomeController::class , 'index'])->name('index');
     Route::post('/subscribe' , [HomeController::class , 'subscribe'])->name('subscribe');
     Route::get('/search' , [HomeController::class , 'search'])->name('search');

     // about-us route
     Route::get('/about-us' , [StaticPageController::class , 'about_us'])->name('about');

    // // faqs route
     Route::get('/faqs' , [StaticPageController::class , 'faqs'])->name('faqs');

    // // privacy policy route
     Route::get('/privacy-policy' , [StaticPageController::class , 'privacy'])->name('privacy');

    // // terms and conditions route
     Route::get('/terms-and-conditions' , [StaticPageController::class , 'terms'])->name('terms');

    // // blog and article routes
     Route::get('/blog' , [StaticPageController::class , 'blog'])->name('blog');
     Route::get('/blog/{id}/{slug}' , [StaticPageController::class , 'article'])->name('article');

    // //contact us routes
     Route::get('/contact-us' , [StaticPageController::class , 'contact_us'])->name('contact');
     Route::post('/contact-us' , [StaticPageController::class , 'store_message']);

    // //companies and institutions routes
     Route::get('/companies-and-institutions' , [StaticPageController::class , 'companies'])->name('companies');
     Route::post('/companies-and-institutions' , [StaticPageController::class , 'company_store']);

    // //become a trainer routes
     Route::get('/become-a-trainer' , [StaticPageController::class , 'trainers'])->name('trainers');
     Route::post('/become-a-trainer' , [StaticPageController::class , 'store_trainer']);

    // // subscription-system route
     Route::get('/subscription-system' , [StaticPageController::class , 'packages'])->name('packages');
     Route::post('/subscription/{id}' , [StaticPageController::class , 'subscribe_to_package'])->name('packages.subscribe');
     // Route::any('/subscription-system/success' , [StaticPageController::class , 'success'])->name('packages.success');

    // // tools and materials routes
     Route::get('/tools-and-materials/{id?}/{slug?}' , [ProductController::class , 'index'])->name('products');
     Route::get('/tools-and-materials/tool/{id}/{slug}' , [ProductController::class , 'product'])->name('product');
     Route::post('/tools-and-materials/tool/add-to-wishlist/{id}' , [ProductController::class , 'wishlist'])->name('product.wishlist');
     Route::delete('/tools-and-materials/tool/remove-from-wishlist/{id}', [ProductController::class , 'remove_from_wishlist'])->name('product.wishlist.remove');
     Route::post('/tools-and-materials/add-to-cart/{id}' , [ProductController::class , 'add_to_cart'])->name('product.cart.add');

    // // courses routes
     Route::get('/courses/{id?}/{slug?}' , [CourseController::class , 'index'])->name('courses');
     Route::get('/free-courses' , [CourseController::class , 'free_courses'])->name('free_courses');
    Route::get('/course/{id}/{slug}' , [CourseController::class , 'course'])->name('course');
     Route::post('course/comment/{id}' , [CourseController::class , 'send_comment'])->name('course.comment');
     Route::post('/courses/add-to-wishlist/{id}' , [CourseController::class , 'wishlist'])->name('course.wishlist');
     Route::delete('/courses/remove-from-wishlist/{id}', [CourseController::class , 'remove_from_wishlist'])->name('course.wishlist.remove');
     Route::post('/courses/add-to-cart/{id}' , [CourseController::class , 'add_to_cart'])->name('course.cart.add');
     Route::get('/courses/show-videos/video/{id}' , [CourseController::class , 'video'])->name('course.video.show');

    // //cart routes
     Route::get('/cart' ,[CartController::class , 'index'])->name('cart');
     Route::get('/remove-from-cart/{id}' , [CartController::class , 'delete'])->name('cart.delete');
     Route::post('/add-coupone' , [CartController::class , 'cart_condition'])->name('cart.discount');

    // /**
    //  * profile routes
    //  */
     Route::name('profile.')->prefix('profile')->middleware('auth:site')->group(function (){
         Route::get('/' , [ProfileController::class , 'index'])->name('index');
         Route::get('/update' , [ProfileController::class , 'profile'])->name('update');
         Route::get('/update/password' , [ProfileController::class , 'password'])->name('update_password');
         Route::put('/update' , [ProfileController::class , 'update_profile']);
         Route::put('/update/password' , [ProfileController::class , 'update_password']);
         Route::get('/tools-and-materials' , [ProfileController::class , 'products'])->name('products');
         Route::get('/courses' , [ProfileController::class , 'courses'])->name('courses');
         Route::get('/subscribtions' ,[ProfileController::class , 'subscribtions'])->name('subscribtions');
         Route::get('/orders' ,[ProfileController::class , 'orders'])->name('orders');
         Route::get('/bill/{id}' , [ProfileController::class , 'bill'])->name('bill');
     });

    // /**
    //  * checkout routes
    //  */
     Route::name('checkout.')->prefix('checkout')->middleware('auth:site')->group(function (){
         Route::get('/' , [CheckoutController::class , 'index'])->name('index');
         Route::post('/opay' , [CheckoutController::class , 'checkout'])->name('opay');
         Route::post('/paymob' , [CheckoutController::class , 'paymob'])->name('paymob');
     });
    
     Route::any('/checkout/success' , [CheckoutController::class , 'success'])->name('checkout.success');
     Route::any('/checkout/return' , [CheckoutController::class , 'return_url'])->name('checkout.return');
     Route::any('/checkout/cancel' , [CheckoutController::class , 'cancel'])->name('checkout.cancel');

     Route::any('/paymob/success' , [CheckoutController::class , 'paymob_success'])->name('paymob.success');

     Route::get('/api/media-converter' , function (Request $request){
         return $request;
     });
});
