<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MembershipBenefitRequest;
use App\Models\MembershipBenefit;
use Illuminate\Http\Request;

class MembershipBenefitController extends Controller
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
            $data = MembershipBenefit::withTrashed()->get()->map(function ($query){
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
                    if ($user->can('membership-benefit-edit')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = '<button class="custom-btn btn btn-primary btn-modal-view" data-url="'.route('admin.membership.edit' , ['membership' => $row['id']]).'" style="margin-left:5px;">تعديل</button>';
                        }
                    }
                    if ($user->can('membership-benefit-delete')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.membership.destroy' , ['membership' => $row['id']]).'">حذف</button>';
                        }else{
                            $btn = $btn.'<button class="custom-btn btn btn-success restore-btn" data-url="'.route('admin.membership.restore' , ['id' => $row['id']]).'" style="margin-left:5px;">إستعاده</button>';
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.membership.force_delete' , ['id' => $row['id']]).'">حذف نهائي</button>';
                        }
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.membership.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MembershipBenefitRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MembershipBenefitRequest $request)
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
     * @param  MembershipBenefit  $benefit
     * @return \Illuminate\Http\Response
     */
    public function edit(MembershipBenefit $membership)
    {
        return view('admin.pages.membership.edit' ,compact('membership'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MembershipBenefitRequest  $request
     * @param  MembershipBenefit  $benefit
     * @return \Illuminate\Http\Response
     */
    public function update(MembershipBenefitRequest $request, MembershipBenefit $membership)
    {
        try {
            $request->update($membership);

            return update_response();
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  MembershipBenefit  $benefit
     * @return \Illuminate\Http\Response
     */
    public function destroy(MembershipBenefit $membership)
    {
        $membership->delete();

        return redirect()->back();
    }

    /**
     * restore specified resource from storage
     *
     * @param MembershipBenefit $benefit
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $benefit = MembershipBenefit::withTrashed()->find($id);
        $benefit->restore();

        return redirect()->back();
    }

    /**
     * Delete the specified resource permanentely from storage
     *
     * @param MembershipBenefit $benefit
     * @return \Illuminate\Http\Response
     */
    public function force_delete($id)
    {
        $benefit = MembershipBenefit::withTrashed()->find($id);
        $benefit->forceDelete();

        return redirect()->back();
    }
}
