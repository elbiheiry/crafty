<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SocialLinkRequest;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
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
            $data = SocialLink::all()->map(function ($query){
                return [
                    'id' => $query->id,
                    'name' => $query->name,
                    'created_at' => $query->created_at->format('d-m-Y')
                ];
            });
            return datatables()->of($data)
                ->addColumn('action', function($row) use ($user){
                    $btn = '';
                    if ($user->can('social-edit')) {
                        $btn = '<button class="custom-btn btn btn-primary btn-modal-view" data-url="'.route('admin.social.edit' , ['link' => $row['id']]).'" style="margin-left:5px;">تعديل</button>';
                    }
                    if ($user->can('social-delete')) {
                        $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.social.destroy' , ['link' => $row['id']]).'">حذف</button>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.social.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SocialLinkRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SocialLinkRequest $request)
    {
        try {
            $request->store();

            return add_response();
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  SocialLink  $link
     * @return \Illuminate\Http\Response
     */
    public function edit(SocialLink $link)
    {
        return view('admin.pages.social.edit' ,compact('link'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SocialLinkRequest  $request
     * @param  SocialLink $link
     * @return \Illuminate\Http\Response
     */
    public function update(SocialLinkRequest $request, SocialLink $link)
    {
        try {
            $request->update($link);

            return update_response();
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  SocialLink $link
     * @return \Illuminate\Http\Response
     */
    public function destroy(SocialLink $link)
    {
        $link->delete();

        return redirect()->back();
    }
}
