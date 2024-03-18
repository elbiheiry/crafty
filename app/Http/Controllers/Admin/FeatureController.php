<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeatureReqeust;
use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
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
            $data = Feature::withTrashed()->get()->map(function ($query){
                return [
                    'id' => $query->id,
                    'title' => $query->translate('ar')->title,
                    'trashed' => $query->trashed() ? 'trashed' : '',
                    'created_at' => $query->created_at->format('d-m-Y')
                ];
            });
            return datatables()->of($data)
                ->addColumn('action', function($row) use ($user){
                    $btn = '';
                    if ($user->can('features-edit')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = '<button class="custom-btn btn btn-primary btn-modal-view" data-url="'.route('admin.features.edit' , ['feature' => $row['id']]).'" style="margin-left:5px;">تعديل</button>';
                        }
                    }
                    if ($user->can('features-delete')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.features.destroy' , ['feature' => $row['id']]).'">حذف</button>';
                        }else{
                            $btn = $btn.'<button class="custom-btn btn btn-success restore-btn" data-url="'.route('admin.features.restore' , ['id' => $row['id']]).'" style="margin-left:5px;">إستعاده</button>';
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.features.force_delete' , ['id' => $row['id']]).'">حذف نهائي</button>';
                        }
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.features.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FeatureReqeust  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FeatureReqeust $request)
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
     * @param  Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function edit(Feature $feature)
    {
        return view('admin.pages.features.edit' ,compact('feature'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FeatureReqeust  $request
     * @param  Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function update(FeatureReqeust $request, Feature $feature)
    {
        try {
            $request->update($feature);

            return update_response();
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feature $feature)
    {
        $feature->delete();

        return redirect()->back();
    }

    /**
     * restore specified resource from storage
     *
     * @param Feature $feature
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $feature = Feature::withTrashed()->find($id);
        $feature->restore();

        return redirect()->back();
    }

    /**
     * Delete the specified resource permanentely from storage
     *
     * @param Feature $feature
     * @return \Illuminate\Http\Response
     */
    public function force_delete($id)
    {
        $feature = Feature::withTrashed()->find($id);
        image_delete($feature->image , 'features');
        $feature->forceDelete();

        return redirect()->back();
    }
}
