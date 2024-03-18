<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:products-create')->only('create');
        $this->middleware('permission:products-edit')->only('edit');
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
            $data = Product::withTrashed()->get()->map(function ($query){
                return [
                    'id' => $query->id,
                    'name' => $query->translate('ar')->name,
                    'category' => $query->category->translate('ar')->name,
                    'slug' => $query->slug,
                    'price' => $query->price,
                    'trashed' => $query->trashed() ? 'trashed' : '',
                    'created_at' => $query->created_at->format('d-m-Y')
                ];
            });
            return datatables()->of($data)
                ->addColumn('name' , function ($row){
                    // dd($row);
                    return '<a style="color:blue;" href="'.route('site.product' , ['id' => $row['id'] , 'slug' => $row['slug']]).'">'.$row['name'].'</a>';
                })
                ->addColumn('action', function($row) use ($user){
                    $btn = '';
                    if ($user->can('products-edit')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = '<a class="custom-btn btn btn-primary" href="'.route('admin.products.edit' , ['product' => $row['id']]).'" style="margin-left:5px;">تعديل</a>';
                        }
                    }
                    if ($user->can('products-delete')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.products.destroy' , ['product' => $row['id']]).'" style="margin-left:5px;">حذف</button>';
                        }else{
                            $btn = $btn.'<button class="custom-btn btn btn-success restore-btn" data-url="'.route('admin.products.restore' , ['id' => $row['id']]).'" style="margin-left:5px;">إستعاده</button>';
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.products.force_delete' , ['id' => $row['id']]).'">حذف نهائي</button>';
                        }
                    }
                    if ($user->can('product-gallery-list')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = $btn.'<a class="custom-btn btn btn-success" href="'.route('admin.products.gallery.index' , ['id' => $row['id']]).'">معرض الصور</a>';
                        }
                    }
                    return $btn;
                })
                ->rawColumns(['name' ,'action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.products.index');
    }

    /**
     * Show the form for creating the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ProductCategory::all()->sortByDesc('id');
        return view('admin.pages.products.create' , compact('categories'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        try {
            $request->store();

            return add_response();
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return error_response();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = ProductCategory::all()->sortByDesc('id');
        return view('admin.pages.products.edit' ,compact('product' , 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductRequest  $request
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        try {
            $request->update($product);

            return update_response();
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->back();
    }

    /**
     * restore specified resource from storage
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $product = Product::withTrashed()->find($id);
        $product->restore();

        return redirect()->back();
    }

    /**
     * Delete the specified resource permanentely from storage
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function force_delete($id)
    {
        $product = Product::withTrashed()->find($id);
        image_delete($product->image , 'products');
        foreach ($product->images() as $key => $image) {
            image_delete($image->image , 'products');
        }
        $product->forceDelete();

        return redirect()->back();
    }
}
