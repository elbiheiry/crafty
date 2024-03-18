<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PackageRequest;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
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
            $data = Package::withTrashed()->get()->map(function ($query){
                return [
                    'id' => $query->id,
                    'name' => $query->translate('ar')->name,
                    'price' => $query->price,
                    'active' => $query->active_subscribers()->count(),
                    'inactive' => $query->inactive_subscribers()->count(),
                    'trashed' => $query->trashed() ? 'trashed' : '',
                    'created_at' => $query->created_at->format('d-m-Y')
                ];
            });
            return datatables()->of($data)
                ->addColumn('action', function($row) use ($user){
                    $btn = '';
                    if(!$row['trashed'] == 'trashed'){
                        $btn = '<a class="custom-btn btn btn-success" href="'.route('admin.packages.members' , ['id' => $row['id']]).'" style="margin-left:5px;">الأعضاء</a>';
                    }
                    if ($user->can('packages-edit')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = $btn.'<button class="custom-btn btn btn-primary btn-modal-view" data-url="'.route('admin.packages.edit' , ['package' => $row['id']]).'" style="margin-left:5px;">تعديل</button>';
                        }
                    }
                    if ($user->can('packages-delete')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.packages.destroy' , ['package' => $row['id']]).'">حذف</button>';
                        }else{
                            $btn = $btn.'<button class="custom-btn btn btn-success restore-btn" data-url="'.route('admin.packages.restore' , ['id' => $row['id']]).'" style="margin-left:5px;">إستعاده</button>';
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.packages.force_delete' , ['id' => $row['id']]).'">حذف نهائي</button>';
                        }
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.packages.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PackageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PackageRequest $request)
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
     * @param  Package   $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        return view('admin.pages.packages.edit' ,compact('package'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PackageRequest  $request
     * @param  Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(PackageRequest $request, Package $package)
    {
        try {
            $request->update($package);

            return update_response();
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        $package->delete();

        return redirect()->back();
    }

    /**
     * restore specified resource from storage
     *
     * @param Package $package
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $package = Package::withTrashed()->find($id);
        $package->restore();

        return redirect()->back();
    }

    /**
     * Delete the specified resource permanentely from storage
     *
     * @param Package $package
     * @return \Illuminate\Http\Response
     */
    public function force_delete($id)
    {
        $package = Package::withTrashed()->find($id);
        image_delete($package->image , 'packages');
        $package->forceDelete();

        return redirect()->back();
    }
}
