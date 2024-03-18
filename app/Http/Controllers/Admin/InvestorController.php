<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvestorRequest;
use App\Models\Investor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvestorController extends Controller
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
            $data = Investor::withTrashed()->get()->map(function ($query){
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
                    if ($user->can('investor-edit')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = '<button class="custom-btn btn btn-primary btn-modal-view" data-url="'.route('admin.investors.edit' , ['investor' => $row['id']]).'" style="margin-left:5px;">تعديل</button>';
                        }
                    }
                    if ($user->can('investor-delete')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.investors.destroy' , ['investor' => $row['id']]).'">حذف</button>';
                        }else{
                            $btn = $btn.'<button class="custom-btn btn btn-success restore-btn" data-url="'.route('admin.investors.restore' , ['id' => $row['id']]).'" style="margin-left:5px;">إستعاده</button>';
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.investors.force_delete' , ['id' => $row['id']]).'">حذف نهائي</button>';
                        }
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.investors.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  InvestorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvestorRequest $request)
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
     * @param  Investor  $investor
     * @return \Illuminate\Http\Response
     */
    public function edit(Investor $investor)
    {
        return view('admin.pages.investors.edit' ,compact('investor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  InvestorRequest  $request
     * @param  Investor $investor
     * @return \Illuminate\Http\Response
     */
    public function update(InvestorRequest $request, Investor $investor)
    {
        try {
            $request->update($investor);

            return update_response();
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Investor $investor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Investor $investor)
    {
        $investor->delete();

        return redirect()->back();
    }

    /**
     * restore specified resource from storage
     *
     * @param Investor $investor
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $investor = Investor::withTrashed()->find($id);
        $investor->restore();

        return redirect()->back();
    }

    /**
     * Delete the specified resource permanentely from storage
     *
     * @param Investor $investor
     * @return \Illuminate\Http\Response
     */
    public function force_delete($id)
    {
        $investor = Investor::withTrashed()->find($id);
        image_delete($investor->image , 'investors');
        $investor->forceDelete();

        return redirect()->back();
    }
}
