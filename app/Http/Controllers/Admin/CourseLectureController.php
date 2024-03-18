<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseLectureRequest;
use App\Models\CourseLecture;
use Illuminate\Http\Request;

class CourseLectureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Course $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = auth()->user();
        if (request()->ajax()) {
            $data = CourseLecture::withTrashed()->where('course_id' , $id)->get()->map(function ($query){
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
                    if ($user->can('course-lecture-edit')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = '<button class="custom-btn btn btn-primary btn-modal-view" data-url="'.route('admin.courses.lectures.edit' , ['lecture' => $row['id']]).'" style="margin-left:5px;">تعديل</a>';
                        }
                    }
                    if ($user->can('course-lecture-delete')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.courses.lectures.destroy' , ['lecture' => $row['id']]).'" style="margin-left:5px;">حذف</button>';
                        }else{
                            $btn = $btn.'<button class="custom-btn btn btn-success restore-btn" data-url="'.route('admin.courses.lectures.restore' , ['id' => $row['id']]).'" style="margin-left:5px;">إستعاده</button>';
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.courses.lectures.force_delete' , ['id' => $row['id']]).'">حذف نهائي</button>';
                        }
                    }
                    if ($user->can('course-lecture-video-list')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = $btn.'<a class="custom-btn btn btn-success" href="'.route('admin.courses.lectures.videos.index' , ['id' => $row['id']]).'" style="margin-left:5px;">الروابط </a>';
                        }
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.courses.lectures.index' , compact('id'));
    }

    /**
     * Show the form for creating the specified resource.
     *
     * @param Course $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('admin.pages.courses.lectures.create' , compact('id'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Course $id
     * @param  CourseLectureRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseLectureRequest $request , $id)
    {
        try {
            $request->store($id);

            return add_response();
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return error_response();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CourseLecture  $lecture
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseLecture $lecture)
    {
        return view('admin.pages.courses.lectures.edit' ,compact('lecture' ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CourseLectureRequest  $request
     * @param  CourseLecture $lecture
     * @return \Illuminate\Http\Response
     */
    public function update(CourseLectureRequest $request, CourseLecture $lecture)
    {
        try {
            $request->update($lecture);

            return update_response();
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CourseLecture $lecture
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseLecture $lecture)
    {
        $lecture->delete();

        return redirect()->back();
    }

    /**
     * restore specified resource from storage
     *
     * @param CourseLecture $course
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $lecture = CourseLecture::withTrashed()->find($id);
        $lecture->restore();

        return redirect()->back();
    }

    /**
     * Delete the specified resource permanentely from storage
     *
     * @param Course $course
     * @return \Illuminate\Http\Response
     */
    public function force_delete($id)
    {
        $lecture = CourseLecture::withTrashed()->find($id);
        $lecture->forceDelete();

        return redirect()->back();
    }
}
