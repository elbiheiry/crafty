<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $allroles = Role::all()->sortByDesc('id');
        if (request()->ajax()) {
            $data = Admin::with('roles')->get()->map(function ($query){
                return [
                    'id' => $query->id,
                    'name' => $query->name,
                    'email' => $query->email,
                    'roles' => $query->roles->map(function ($role) {
                        return $role->name;
                    }),
                    'created_at' => $query->created_at->format('d-m-Y')
                ];
            });
            return datatables()->of($data)
                ->addColumn('action', function($row) use ($user){
                    $btn = '';
                    if ($user->can('admin-edit')) {
                        $btn = '<button class="custom-btn btn btn-primary btn-modal-view" data-url="'.route('admin.admins.edit' , ['admin' => $row['id']]).'" style="margin-left:5px;">تعديل</button>';
                    }
                    if ($user->can('admin-delete')) {
                        $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.admins.destroy' , ['admin' => $row['id']]).'">حذف</button>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.admins.index' , compact('allroles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AdminRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
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
     * @param  Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        return view('admin.pages.admins.edit', [
            'admin' => $admin,
            'adminRole' => $admin->roles->pluck('name')->toArray(),
            'allroles' => Role::all()->sortByDesc('id')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AdminRequest  $request
     * @param  Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, Admin $admin)
    {
        try {
            $request->update($admin);

            return update_response();
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();

        return redirect()->back();
    }
}
