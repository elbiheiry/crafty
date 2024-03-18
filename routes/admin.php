<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\CompanyGalleryController;
use App\Http\Controllers\Admin\CouponeController;
use App\Http\Controllers\Admin\CourseCategoryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CourseLectureController;
use App\Http\Controllers\Admin\CourseLectureVideoController;
use App\Http\Controllers\Admin\FaqCategoryController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\InvestorController;
use App\Http\Controllers\Admin\MembershipBenefitController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PackageMemberController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductGalleryController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SocialLinkController;
use App\Http\Controllers\Admin\SubscribeController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\TrainerController;

Route::get('login', [LoginController::class , 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class , 'login']);
Route::post('logout', [LoginController::class , 'logout'])->name('logout');
Route::get('/reset-password' , [ResetPasswordController::class , 'index'])->name('password.reset');
Route::post('/reset-password/confrim-password' , [ResetPasswordController::class , 'send_mail'])->name('password.confirm');
Route::get('/change-password/{email}' , [ResetPasswordController::class , 'edit_password'])->name('password.change');
Route::post('/change-password/update/{email}' , [ResetPasswordController::class , 'change_password'])->name('password.update');

Route::group(['middleware' => ['auth:web']], function() {

    //dashboard route
    Route::get('/', [HomeController::class, 'index'])->name('index');

    /**
     * Settings Routes
     */
    Route::prefix('site-settings')->middleware(['permission:settings-edit'])->name('settings.')->group(function() {
        Route::get('/', [SettingController::class , 'index'])->name('index');
        Route::put('/update',[SettingController::class , 'update'])->name('update');

        // Route::resource('settings' , SettingController::class)->only(['index' , 'update']);
    });

    /**
     * about us Routes
     */
    Route::prefix('about-us')->middleware(['permission:about-edit'])->name('about.')->group(function() {
        Route::get('/', [AboutController::class , 'index'])->name('index');
        Route::put('/update',[AboutController::class , 'update'])->name('update');

        // Route::resource('about' , AboutController::class)->only(['index' , 'update']);
    });

    /**
     * Admin Routes
     */
    Route::middleware(['permission:admin-list'])->group(function() {
        Route::resource('admins' ,AdminController::class)->only(['index' , 'store' , 'edit' , 'update' , 'destroy']);
    });

    /**
     * Role Routes
     */
    Route::middleware('permission:role-list')->group(function() {
        Route::resource('roles' ,RoleController::class)->only(['index' , 'store' , 'edit' , 'update' , 'destroy']);
        Route::post('/roles/{id}/restore' , [RoleController::class , 'restore'])->name('roles.restore');
        Route::delete('/roles/{id}/force-delete',[RoleController::class , 'force_delete'])->name('roles.force_delete');
    });

    /**
     * social-links Routes
     */
    Route::middleware('permission:social-list')->group(function() {
        Route::resource('social' , SocialLinkController::class)->only(['index' , 'store' , 'edit' , 'update' ,'destroy']);
    });

    /**
     * features Routes
     */
    Route::middleware('permission:features-list')->group(function() {
        Route::post('/features/{id}/restore' , [FeatureController::class , 'restore'])->name('features.restore');
        Route::delete('/features/{id}/force-delete',[FeatureController::class , 'force_delete'])->name('features.force_delete');

        Route::resource('features' ,FeatureController::class)->only(['index' , 'store' , 'edit' , 'update' , 'destroy']);
    });

    /**
     * faqs Routes
     */
    Route::middleware('permission:faqs-list')->group(function() {
        Route::resource('faqs' ,FaqController::class)->only(['index' , 'store' , 'edit' , 'update' , 'destroy']);
        Route::post('/faqs/{id}/restore' , [FaqController::class , 'restore'])->name('faqs.restore');
        Route::delete('/faqs/{id}/force-delete',[FaqController::class , 'force_delete'])->name('faqs.force_delete');
    });

    /**
     * faqs categories Routes
     */
    Route::prefix('faqs')->middleware('permission:faq-category-list')->name('faqs.')->group(function() {
        Route::resource('category' ,FaqCategoryController::class)->only(['index' , 'store' , 'edit' , 'update' , 'destroy']);
        Route::post('/category/{id}/restore' , [FaqCategoryController::class , 'restore'])->name('category.restore');
        Route::delete('/category/{id}/force-delete',[FaqCategoryController::class , 'force_delete'])->name('category.force_delete');
    });

    /**
     * team Routes
     */
    Route::middleware('permission:team-list')->group(function() {
        Route::resource('team' ,TeamController::class)->only(['index' , 'store' , 'edit' , 'update' , 'destroy']);
        Route::post('/team/{id}/restore' , [TeamController::class , 'restore'])->name('team.restore');
        Route::delete('/team/{id}/force-delete',[TeamController::class , 'force_delete'])->name('team.force_delete');
    });

    /**
     * investors Routes
     */
    Route::middleware('permission:investor-list')->group(function() {
        Route::resource('investors' ,InvestorController::class)->only(['index' , 'store' , 'edit' , 'update' , 'destroy']);

        Route::post('/investors/{id}/restore' , [InvestorController::class , 'restore'])->name('investors.restore');
        Route::delete('/investors/{id}/force-delete',[InvestorController::class , 'force_delete'])->name('investors.force_delete');
    });

    /**
     * packages Routes
     */
    Route::middleware('permission:packages-list')->group(function() {
        Route::resource('packages' ,PackageController::class)->only(['index' , 'store' , 'edit' , 'update' , 'destroy']);
        Route::post('/packages/{id}/restore' , [PackageController::class , 'restore'])->name('packages.restore');
        Route::delete('/packages/{id}/force-delete',[PackageController::class , 'force_delete'])->name('packages.force_delete');
        Route::get('/packages/members/{id}' , [PackageMemberController::class , 'index'])->name('packages.members');
        Route::get('/packages/members/delete/{id}' , [PackageMemberController::class , 'destroy'])->name('packages.members.delete');
    });

    /**
     * membership-benefits Routes
     */
    Route::middleware('permission:membership-benefit-list')->group(function() {
        Route::resource('membership' ,MembershipBenefitController::class)->only(['index' , 'store' , 'edit' , 'update' , 'destroy']);
        Route::post('/membership/{id}/restore' , [MembershipBenefitController::class , 'restore'])->name('membership.restore');
        Route::delete('/membership/{id}/force-delete',[MembershipBenefitController::class , 'force_delete'])->name('membership.force_delete');
    });

    /**
     * Blog Routes
     */
    Route::middleware('permission:article-list')->group(function() {
        Route::resource('articles' ,ArticleController::class)->only(['index' , 'create' , 'store' , 'edit' , 'update' , 'destroy']);
        Route::post('/articles/{id}/restore' , [ArticleController::class , 'restore'])->name('articles.restore');
        Route::delete('/articles/{id}/force-delete',[ArticleController::class , 'force_delete'])->name('articles.force_delete');
    });

    /**
     * Trainers Routes
     */
    Route::middleware('permission:trainers-list')->group(function() {
        Route::resource('trainers' ,TrainerController::class)->only(['index' , 'show', 'destroy']);
    });

    /**
     * Company Routes
     */
    Route::middleware('permission:company-list')->group(function() {
        Route::resource('company' ,CompanyController::class)->only(['index' , 'show', 'destroy']);
    });

    /**
     * company gallery Routes
     */
    Route::prefix('gallery')->middleware('permission:company-gallery-list')->name('company.gallery.')->group(function() {
        Route::get('/', [CompanyGalleryController::class , 'index1'])->name('index');
        Route::post('/store', [CompanyGalleryController::class , 'store'])->name('store');
        Route::get('/{image}/edit', [CompanyGalleryController::class , 'edit'])->name('edit');
        Route::put('/{image}/update',[CompanyGalleryController::class , 'update'])->name('update');
        Route::delete('/{image}/delete',[CompanyGalleryController::class , 'destroy'])->name('destroy');
        // Route::resource('gallery' ,CompanyGalleryController::class)->only(['index' ,'store' , 'edit' , 'update', 'destroy']);
        Route::post('/{id}/restore' , [CompanyGalleryController::class , 'restore'])->name('restore');
        Route::delete('/{id}/force-delete',[CompanyGalleryController::class , 'force_delete'])->name('force_delete');
    });

    /**
     * Permission Routes
     */

    Route::resource('permissions' ,PermissionController::class)->only(['index' ,'store' , 'edit' , 'update', 'destroy']);

    /**
     * product-category Routes
     */
    Route::prefix('products')->middleware('permission:product-category-list')->name('products.')->group(function() {
        // Route::get('/', [ProductCategoryController::class , 'index'])->name('index');
        // Route::post('/store', [ProductCategoryController::class , 'store'])->name('store');
        // Route::get('/{category}/edit', [ProductCategoryController::class , 'edit'])->name('edit');
        // Route::put('/{category}/update',[ProductCategoryController::class , 'update'])->name('update');
        // Route::delete('/{category}/delete',[ProductCategoryController::class , 'destroy'])->name('destroy');

        Route::resource('category' ,ProductCategoryController::class)->only(['index' ,'store' , 'edit' , 'update', 'destroy']);
        Route::post('/category/{id}/restore' , [ProductCategoryController::class , 'restore'])->name('category.restore');
        Route::delete('/category/{id}/force-delete',[ProductCategoryController::class , 'force_delete'])->name('category.force_delete');
    });

    /**
     * messages Routes
     */
    Route::middleware('permission:messages-list')->group(function() {
        Route::resource('messages' ,MessageController::class)->only(['index' ,'show' , 'destroy']);
        Route::post('/messages/{id}/restore' , [MessageController::class , 'restore'])->name('messages.restore');
        Route::delete('/messages/{id}/force-delete',[MessageController::class , 'force_delete'])->name('messages.force_delete');
    });

    /**
     * subscribers Routes
     */
    Route::middleware('permission:subscribers-list')->group(function() {
        Route::resource('subscribers' ,SubscribeController::class)->only(['index' , 'destroy']);
    });

    /**
     * products Routes
     */
    Route::middleware('permission:products-list')->group(function() {
        Route::resource('products' ,ProductController::class)->only(['index','create','store','edit','update','destroy']);
        Route::post('/products/{id}/restore' , [ProductController::class , 'restore'])->name('products.restore');
        Route::delete('/products/{id}/force-delete',[ProductController::class , 'force_delete'])->name('products.force_delete');

        /**
         * gallery Routes
         */
        Route::prefix('products/gallery')->middleware('permission:product-gallery-list')->name('products.gallery.')->group(function() {
            Route::get('/{id}', [ProductGalleryController::class , 'index'])->name('index');
            Route::post('/store/{id}', [ProductGalleryController::class , 'store'])->name('store');
            Route::get('/{image}/edit', [ProductGalleryController::class , 'edit'])->name('edit');
            Route::put('/{image}/update',[ProductGalleryController::class , 'update'])->name('update');
            Route::delete('/{image}/delete',[ProductGalleryController::class , 'destroy'])->name('destroy');

            // Route::resource('gallery' ,ProductGalleryController::class)->only(['index','store','edit','update','destroy']);
            Route::post('/{id}/restore' , [ProductGalleryController::class , 'restore'])->name('restore');
            Route::delete('/{id}/force-delete',[ProductGalleryController::class , 'force_delete'])->name('force_delete');
        });
    });
    
    /**
     * course-category Routes
     */
    Route::prefix('courses')->middleware('permission:course-category-list')->name('courses.')->group(function() {
        Route::resource('category' ,CourseCategoryController::class)->only(['index','store','edit','update','destroy']);
        Route::post('/categorie/{id}/restore' , [CourseCategoryController::class , 'restore'])->name('category.restore');
        Route::delete('/categorie/{id}/force-delete',[CourseCategoryController::class , 'force_delete'])->name('category.force_delete');
    });

    /**
     * coupone Routes
     */
    Route::middleware('permission:coupones-list')->group(function() {
        Route::resource('coupones' ,CouponeController::class)->only(['index','store','edit','update','destroy']);
        Route::post('/coupones/{id}/restore' , [CouponeController::class , 'restore'])->name('coupones.restore');
        Route::delete('/coupones/{id}/force-delete',[CouponeController::class , 'force_delete'])->name('coupones.force_delete');
    });

    /**
     * course Routes
     */
    Route::prefix('courses')->middleware('permission:course-list')->name('courses.')->group(function() {
        Route::get('/{type}', [CourseController::class , 'index'])->name('index');
        Route::get('/create/{type}', [CourseController::class , 'create'])->name('create');
        Route::post('/store/{type}', [CourseController::class , 'store'])->name('store');
        Route::get('/{course}/edit', [CourseController::class , 'edit'])->name('edit');
        Route::post('/{course}/update',[CourseController::class , 'update'])->name('update');
        Route::delete('/{course}/delete',[CourseController::class , 'destroy'])->name('destroy');
        Route::post('/{id}/restore' , [CourseController::class , 'restore'])->name('restore');
        Route::delete('/{id}/force-delete',[CourseController::class , 'force_delete'])->name('force_delete');

        /**
         * lectures Routes
         */
        Route::prefix('lectures')->middleware('permission:course-lecture-list')->name('lectures.')->group(function() {
            Route::get('/{id}', [CourseLectureController::class , 'index'])->name('index');
            Route::get('/{id}/create', [CourseLectureController::class , 'create'])->name('create');
            Route::post('/{id}/store', [CourseLectureController::class , 'store'])->name('store');
            Route::get('/{lecture}/edit', [CourseLectureController::class , 'edit'])->name('edit');
            Route::put('/{lecture}/update',[CourseLectureController::class , 'update'])->name('update');
            Route::delete('/{lecture}/delete',[CourseLectureController::class , 'destroy'])->name('destroy');
            Route::post('/{id}/restore' , [CourseLectureController::class , 'restore'])->name('restore');
            Route::delete('/{id}/force-delete',[CourseLectureController::class , 'force_delete'])->name('force_delete');

            /**
             * lectures Routes
             */
            Route::prefix('videos')->middleware('permission:course-lecture-video-list')->name('videos.')->group(function() {
                Route::get('/{id}', [CourseLectureVideoController::class , 'index'])->name('index');
                Route::post('/{id}/store', [CourseLectureVideoController::class , 'store'])->name('store');
                Route::get('/{video}/edit', [CourseLectureVideoController::class , 'edit'])->name('edit');
                Route::post('/{video}/update',[CourseLectureVideoController::class , 'update'])->name('update');
                Route::delete('/{video}/delete',[CourseLectureVideoController::class , 'destroy'])->name('destroy');
                Route::post('/{id}/restore' , [CourseLectureVideoController::class , 'restore'])->name('restore');
                Route::delete('/{id}/force-delete',[CourseLectureVideoController::class , 'force_delete'])->name('force_delete');
            });
        });
    });
});
