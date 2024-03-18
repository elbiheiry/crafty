<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyGalleryRequest;
use App\Models\CompanyGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index1()
    {
        $user = auth()->user();
        if (request()->ajax()) {
            $data = CompanyGallery::withTrashed()->get()->map(function ($query){
                $url = Storage::disk('s3.assets')->temporaryUrl('assets/'.$query->image,\Carbon\Carbon::now()->addMinutes(120));
                return [
                    'id' => $query->id,
                    'image' => $url,
                    'trashed' => $query->trashed() ? 'trashed' : '',
                    'created_at' => $query->created_at->format('d-m-Y')
                ];
            });
            return datatables()->of($data)
                ->addColumn('action', function($row) use ($user){
                    $btn = '';
                    if ($user->can('company-gallery-edit')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = '<button class="custom-btn btn btn-primary btn-modal-view" data-url="'.route('admin.company.gallery.edit' , ['image' => $row['id']]).'" style="margin-left:5px;">تعديل</button>';
                        }
                    }
                    if ($user->can('company-gallery-delete')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.company.gallery.destroy' , ['image' => $row['id']]).'">حذف</button>';
                        }else{
                            $btn = $btn.'<button class="custom-btn btn btn-success restore-btn" data-url="'.route('admin.company.gallery.restore' , ['id' => $row['id']]).'" style="margin-left:5px;">إستعاده</button>';
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.company.gallery.force_delete' , ['id' => $row['id']]).'">حذف نهائي</button>';
                        }
                        
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.company.gallery.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CompanyGalleryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyGalleryRequest $request)
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
     * @param  CompanyGallery  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(CompanyGallery $image)
    {
        return view('admin.pages.company.gallery.edit' ,compact('image'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CompanyGalleryRequest  $request
     * @param  CompanyGallery  $image
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyGalleryRequest $request, CompanyGallery $image)
    {
        try {
            $request->update($image);

            return update_response();
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CompanyGallery $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanyGallery $image)
    {
        $image->delete();

        return redirect()->back();
    }

    /**
     * restore specified resource from storage
     *
     * @param CompanyGallery $image
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $image = CompanyGallery::withTrashed()->find($id);
        $image->restore();

        return redirect()->back();
    }

    /**
     * Delete the specified resource permanentely from storage
     *
     * @param CompanyGallery $image
     * @return \Illuminate\Http\Response
     */
    public function force_delete($id)
    {
        $image = CompanyGallery::withTrashed()->find($id);
        image_delete($image->image , 'company');
        $image->forceDelete();

        return redirect()->back();
    }
}
