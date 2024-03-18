<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:trainers-show')->only('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        if (request()->ajax()) {
            $data = Trainer::get()->map(function ($query){
                return [
                    'id' => $query->id,
                    'name' => $query->name,
                    'phone' => $query->phone,
                    'email' => $query->email,
                    'created_at' => $query->created_at->format('d-m-Y')
                ];
            });
            return datatables()->of($data)
                ->addColumn('action', function($row) use ($user){
                    $btn = '';
                    if ($user->can('trainers-show')) {
                        $btn = '<a class="custom-btn btn btn-primary" href="'.route('admin.trainers.show' , ['trainer' => $row['id']]).'" style="margin-left:5px;">عرض</a>';
                    }
                    if ($user->can('trainers-delete')) {
                        $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.trainers.destroy' , ['trainer' => $row['id']]).'">حذف</button>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.trainers.index');
    }

    /**
     * Show the specified resource from storage
     *
     * @param Trainer $trainer
     * @return \Illuminate\Http\Response
     */
    public function show(Trainer $trainer)
    {
        return view('admin.pages.trainers.show' ,compact('trainer'));
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  Trainer $trainer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trainer $trainer)
    {
        $trainer->delete();

        return redirect()->back();
    }
}
