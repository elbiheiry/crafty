<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Coupone;
use Illuminate\Http\Request;

class CartController extends Controller
{
 
    /**
     * return cart page with it's contents
     *
     * @return Redirect
     */
    public function index()
    {
        $items = \Cart::getContent();

        return view('site.pages.cart.index' ,compact('items'));
    }

    /**
     * add coupone discount to cart
     *
     * @param Request $request
     * @return Redirect
     */
    public function cart_condition(Request $request)
    {
        $validator = validator($request->all() ,[
            'discount' => ['required' , 'string' , 'max:225']
        ] ,[] ,[
            'discount' => 'كود الخصم'
        ]);

        if ($validator->fails()) {
            return failed_validation($validator->errors()->first());
        }

        $coupone = Coupone::where('coupone' , $request->discount)->first();

        if (!$coupone) {
            return response()->json('القيمة المدخلة غير صحيحة' , 400);
        }

        try {
            $coupon101 = new \Darryldecode\Cart\CartCondition(array(
                'name' => 'Coupone code : '.$coupone->coupone,
                'type' => 'discount-code',
                'target' => 'total',
                'value' => '-'.$coupone->discount.'%'
            ));
            \Cart::condition($coupon101);

            return response()->json( \Cart::getTotal() ,200);
        } catch (\Throwable $th) {

            return error_response();
        }
    }

    /**
     * remove item from cart
     *
     * @param integer $id
     * @return Redirect
     */
    public function delete($id)
    {
        \Cart::remove($id);

        return redirect()->back();
    }
}
