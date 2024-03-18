<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FaqCategoryRequest;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class FaqCategoryController extends Controller
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
            $data = FaqCategory::withTrashed()->get()->map(function ($query){
                return [
                    'id' => $query->id,
                    'name' => $query->translate('ar')->name,
                    'trashed' => $query->trashed() ? 'trashed' : '',
                    'created_at' => $query->created_at->format('d-m-Y')
                ];
            });
            return datatables()->of($data)
                ->addColumn('action', function($row) use ($user){
                    $btn = '';
                    if ($user->can('faq-category-edit')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = '<button class="custom-btn btn btn-primary btn-modal-view" data-url="'.route('admin.faqs.category.edit' , ['category' => $row['id']]).'" style="margin-left:5px;">تعديل</button>';
                    
                        }
                    }
                    if ($user->can('faq-category-delete')) {
                        
                        if(!$row['trashed'] == 'trashed'){
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.faqs.category.destroy' , ['category' => $row['id']]).'">حذف</button>';
                        }else{
                            $btn = $btn.'<button class="custom-btn btn btn-success restore-btn" data-url="'.route('admin.faqs.category.restore' , ['id' => $row['id']]).'" style="margin-left:5px;">إستعاده</button>';
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.faqs.category.force_delete' , ['id' => $row['id']]).'">حذف نهائي</button>';
                        }
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.faqs.category.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FaqCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FaqCategoryRequest $request)
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
     * @param FaqCategory $category
     * @return \Illuminate\Http\Response
     */
    public function edit(FaqCategory $category)
    {
        return view('admin.pages.faqs.categort.edit' ,compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FaqCategoryRequest $request
     * @param FaqCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function update(FaqCategoryRequest $request, FaqCategory $category)
    {
        try {
            $request->update($category);

            return update_response();
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  FaqCategory $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(FaqCategory $category)
    {
        $category->delete();

        return redirect()->back();
    }

    /**
     * restore specified resource from storage
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $category = FaqCategory::withTrashed()->find($id);
        $category->restore();

        return redirect()->back();
    }

    /**
     * Delete the specified resource permanentely from storage
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function force_delete($id)
    {
        $category = FaqCategory::withTrashed()->find($id);
        $category->forceDelete();

        return redirect()->back();
    }
}