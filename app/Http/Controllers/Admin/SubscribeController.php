<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        if (request()->ajax()) {
            $data = Subscriber::get()->map(function ($query){
                return [
                    'id' => $query->id,
                    'email' => $query->email,
                    'created_at' => $query->created_at->format('d-m-Y')
                ];
            });
            return datatables()->of($data)
                ->addColumn('action', function($row) use ($user){
                    $btn = '';
                    if ($user->can('subscribers-delete')) {
                        $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.subscribers.destroy' , ['subscriber' => $row['id']]).'">حذف</button>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.subscribers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();

        return redirect()->back();
    }
}
