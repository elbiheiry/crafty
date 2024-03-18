<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FaqRequest;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $categories = Faq::all()->sortByDesc('id');
        if (request()->ajax()) {
            $data = Faq::withTrashed()->get()->map(function ($query){
                return [
                    'id' => $query->id,
                    'question' => $query->translate('ar')->question,
                    'category' => $query->category->translate('ar')->name,
                    'trashed' => $query->trashed() ? 'trashed' : '',
                    'created_at' => $query->created_at->format('d-m-Y')
                ];
            });
            return datatables()->of($data)
                ->addColumn('action', function($row) use ($user){
                    $btn = '';
                    if ($user->can('faqs-edit')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = '<button class="custom-btn btn btn-primary btn-modal-view" data-url="'.route('admin.faqs.edit' , ['faq' => $row['id']]).'" style="margin-left:5px;">تعديل</button>';
                    
                        }
                    }
                    if ($user->can('faqs-delete')) {
                        
                        if(!$row['trashed'] == 'trashed'){
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.faqs.destroy' , ['faq' => $row['id']]).'">حذف</button>';
                        }else{
                            $btn = $btn.'<button class="custom-btn btn btn-success restore-btn" data-url="'.route('admin.faqs.restore' , ['id' => $row['id']]).'" style="margin-left:5px;">إستعاده</button>';
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.faqs.force_delete' , ['id' => $row['id']]).'">حذف نهائي</button>';
                        }
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.faqs.index' ,compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FaqRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FaqRequest $request)
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
     * @param  Faq   $faq
     * @return \Illuminate\Http\Response
     */
    public function edit(Faq $faq)
    {
        $categories = FaqCategory::all()->sortByDesc('id');

        return view('admin.pages.faqs.edit' ,compact('faq' , 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FaqRequest  $request
     * @param  Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(FaqRequest $request, Faq $faq)
    {
        try {
            $request->update($faq);

            return update_response();
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->back();
    }

    /**
     * restore specified resource from storage
     *
     * @param Faq $faq
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $faq = Faq::withTrashed()->find($id);
        $faq->restore();

        return redirect()->back();
    }

    /**
     * Delete the specified resource permanentely from storage
     *
     * @param Faq $faq
     * @return \Illuminate\Http\Response
     */
    public function force_delete($id)
    {
        $faq = Faq::withTrashed()->find($id);
        $faq->forceDelete();

        return redirect()->back();
    }
}
