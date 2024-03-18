<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductGalleryRequest;
use App\Models\ProductGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Product $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = auth()->user();
        if (request()->ajax()) {
            $data = ProductGallery::withTrashed()->get()->where('product_id' , $id)->map(function ($query){
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
                    if ($user->can('product-gallery-edit')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = '<button class="custom-btn btn btn-primary btn-modal-view" data-url="'.route('admin.products.gallery.edit' , ['image' => $row['id']]).'" style="margin-left:5px;">تعديل</button>';
                        }
                    }
                    if ($user->can('product-gallery-delete')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.products.gallery.destroy' , ['image' => $row['id']]).'">حذف</button>';
                        }else{
                            $btn = $btn.'<button class="custom-btn btn btn-success restore-btn" data-url="'.route('admin.products.gallery.restore' , ['id' => $row['id']]).'" style="margin-left:5px;">إستعاده</button>';
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.products.gallery.force_delete' , ['id' => $row['id']]).'">حذف نهائي</button>';
                        }
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.products.gallery.index' , compact('id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductGalleryRequest  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function store(ProductGalleryRequest $request , $id)
    {
        try {
            $request->store($id);

            return add_response();
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ProductGallery  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductGallery $image)
    {
        return view('admin.pages.products.gallery.edit' ,compact('image'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductGalleryRequest  $request
     * @param  ProductGallery  $image
     * @return \Illuminate\Http\Response
     */
    public function update(ProductGalleryRequest $request, ProductGallery $image)
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
     * @param  ProductGallery $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductGallery $image)
    {
        $image->delete();

        return redirect()->back();
    }

    /**
     * restore specified resource from storage
     *
     * @param ProductGallery $image
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $image = ProductGallery::withTrashed()->find($id);
        $image->restore();

        return redirect()->back();
    }

    /**
     * Delete the specified resource permanentely from storage
     *
     * @param ProductGallery $image
     * @return \Illuminate\Http\Response
     */
    public function force_delete($id)
    {
        $image = ProductGallery::withTrashed()->find($id);
        image_delete($image->image , 'products');
        $image->forceDelete();

        return redirect()->back();
    }
}
