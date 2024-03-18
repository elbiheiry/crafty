<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\UserSubscribtion;
use Illuminate\Http\Request;

class PackageMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $subscribers = UserSubscribtion::whereHas('order', function ($query) {
            $query->where('status' , '!=','Done')->orWhere('status' , 'Done');
        })->where('package_id' , $id)->orderBy('id' , 'desc')->get();

        $orders = Order::all()->where('user_subscribtion_id' , '!=' , null);

        $users = [];
        foreach ($orders as $order) {
            $order_details = json_decode($order->order_details);
            if ($order_details->package_id == $id) {
                array_push($users , $order_details->user_id);    
            }
        }
        return view('admin.pages.packages.members' , compact('subscribers'));
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserSubscribtion::findOrFail($id)->delete();

        return redirect()->back();
    }
}
