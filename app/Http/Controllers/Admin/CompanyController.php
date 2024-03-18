<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:company-show')->only('show');
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
            $data = Company::get()->map(function ($query){
                return [
                    'id' => $query->id,
                    'name' => $query->name,
                    'company' => $query->company_name,
                    'phone' => $query->phone,
                    'email' => $query->email,
                    'created_at' => $query->created_at->format('d-m-Y')
                ];
            });
            return datatables()->of($data)
                ->addColumn('action', function($row) use ($user){
                    $btn = '';
                    if ($user->can('company-show')) {
                        $btn = '<a class="custom-btn btn btn-primary" href="'.route('admin.company.show' , ['company' => $row['id']]).'" style="margin-left:5px;">عرض</a>';
                    }
                    if ($user->can('company-delete')) {
                        $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.company.destroy' , ['company' => $row['id']]).'">حذف</button>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.company.index');
    }

    /**
     * Show the specified resource from storage
     *
     * @param Company $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return view('admin.pages.company.show' ,compact('company'));
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  Company $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->back();
    }
}
