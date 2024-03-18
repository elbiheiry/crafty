<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponeRequest;
use App\Models\Coupone;
use Illuminate\Http\Request;

class CouponeController extends Controller
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
            $data = Coupone::withTrashed()->get()->map(function ($query){
                return [
                    'id' => $query->id,
                    'coupone' => $query->coupone,
                    'discount' => $query->discount,
                    'trashed' => $query->trashed() ? 'trashed' : '',
                    'created_at' => $query->created_at->format('d-m-Y')
                ];
            });
            return datatables()->of($data)
                ->addColumn('action', function($row) use ($user){
                    $btn = '';
                    if ($user->can('coupones-edit')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = '<button class="custom-btn btn btn-primary btn-modal-view" data-url="'.route('admin.coupones.edit' , ['coupone' => $row['id']]).'" style="margin-left:5px;">تعديل</button>';
                        }
                    }
                    if ($user->can('coupones-delete')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.coupones.destroy' , ['coupone' => $row['id']]).'">حذف</button>';
                        }else{
                            $btn = $btn.'<button class="custom-btn btn btn-success restore-btn" data-url="'.route('admin.coupones.restore' , ['id' => $row['id']]).'" style="margin-left:5px;">إستعاده</button>';
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.coupones.force_delete' , ['id' => $row['id']]).'">حذف نهائي</button>';
                        }
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.coupones.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CouponeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CouponeRequest $request)
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
     * @param  Coupone  $coupone
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupone $coupone)
    {
        return view('admin.pages.coupones.edit' ,compact('coupone'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CouponeRequest  $request
     * @param  Coupone  $coupone
     * @return \Illuminate\Http\Response
     */
    public function update(CouponeRequest $request, Coupone $coupone)
    {
        try {
            $request->update($coupone);

            return update_response();
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Coupone  $coupone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupone $coupone)
    {
        $coupone->deleted_by = auth()->id();
        $coupone->save();
        $coupone->delete();

        return redirect()->back();
    }

    /**
     * restore specified resource from storage
     *
     * @param Coupone $coupone
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $coupone = Coupone::withTrashed()->find($id);
        $coupone->restore();

        return redirect()->back();
    }

    /**
     * Delete the specified resource permanentely from storage
     *
     * @param Coupone $coupone
     * @return \Illuminate\Http\Response
     */
    public function force_delete($id)
    {
        $coupone = Coupone::withTrashed()->find($id);
        $coupone->forceDelete();

        return redirect()->back();
    }
}
