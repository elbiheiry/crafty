<?php

namespace App\Http\Controllers\Site;

use App\Filters\ProductFilter;
use App\Http\Controllers\Controller;
use App\Models\CourseProduct;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductWishlist;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Show index page.
     *
     * @param ProductCategory $id
     * @return \Illuminate\Http\Response
     */
    public function index(ProductFilter $filter, $id = null , $slug = null)
    {
        if($id){
            $products = Product::filter($filter)->where('product_category_id' , $id)->get();
        }else{
            $products = Product::filter($filter)->get();
        }
        
        $categories = ProductCategory::all()->sortByDesc('id');

        if (request()->ajax()) {
            if($id){
                $products = Product::filter($filter)->where('product_category_id' , $id)->get();
            }else{
                $products = Product::filter($filter)->get();
            }

            return view( 'site.pages.products.templates.products', compact( 'products' ) );
        }

        return view('site.pages.products.index' ,compact('products' , 'categories'));
    }

    /**
     * Show single product page.
     *
     * @return \Illuminate\Http\Response
     */
    public function product($id , $slug)
    {
        $product = Product::findOrFail($id);
        $related_products = Product::all()->sortByDesc('id')->take(6)->where('product_category_id' , $product->product_category_id)->where('id' , '!=' , $id);

        $courses = CourseProduct::all()->sortByDesc('id')->where('product_id' , $id);

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

        return view('site.pages.products.product' , compact('product' , 'related_products' , 'courses' , 'course_ids'));
    }

    /**
     * add product to wishlist
     *
     * @param Request $request
     * @param Product $id
     * @return Response
     */
    public function wishlist(Request $request , $id)
    {
        $user = auth()->guard('site')->user();

        if (auth()->guard('site')->guest()) {
            return failed_validation('برجاء تسجيل الدخول اولا ' , 400);
        }

        if ($user->product_wishlists()->where('product_id' , $id)->first()) {
            return failed_validation('هذا المنتج مضاف بالفعل لقائمة الادوات المفضله' , 400);
        }else{
            try {
                $user->product_wishlists()->create([
                    'product_id' => $id
                ]);

                return response()->json( 'تم إضافة هذه الأدوات لقائمه المفضله لديك ', 200);
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
        ProductWishlist::findOrFail($id)->delete();

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
        $product = Product::findOrFail($id);
        $quantity = $request->quantity;
        $item = \Cart::get($id.'+product');

        try {
            if ($item != null){
                if ($request->quantity) {
                    \Cart::update($item->id , [
                        'quantity' => [
                            'relative' => false,
                            'value' => $request->quantity
                        ]
                    ]);
                }else{
                    // $value = $item->quantity +1;
                    \Cart::update($item->id , [
                        'quantity' => 1
                    ]);
                }
                
                return response()->json([
                    'message' => 'تم تحديث كميه المنتج في سله الشراء بنجاح',
                    'counter' => \Cart::getContent()->count()
                ] ,200);
            }else{
                \Cart::add([
                    'id' => $id.'+product',
                    'name' => $product->translate(app()->getLocale())->name,
                    'quantity' => $quantity ? $quantity : 1,
                    'price' => $product->price,
                    'associatedModel' => 'product',
                    'attributes' => [
                        'id' => $product->id,
                        'image' => $product->image,
                        'slug' => $product->slug
                    ]
                ]);
            }
            return response()->json([
                'message' => 'تم إضافه المنتج لسلة المشتريات بنجاح',
                'counter' => \Cart::getContent()->count()
            ] ,200);
        } catch (\Throwable $th) {
            return error_response();
        }
    }
}
