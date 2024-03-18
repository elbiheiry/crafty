<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseLectureVideoRequest;
use App\Models\CourseLecture;
use App\Models\CourseLectureVideo;
use Illuminate\Http\Request;

class CourseLectureVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CourseLecture $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = auth()->user();
        $lecture = CourseLecture::findOrFail($id);
        $type = $lecture->course['price'] == 'null' ? 'free' : 'paid';
        if (request()->ajax()) {
            $data = CourseLectureVideo::withTrashed()->where('course_lecture_id' , $id)->get()->map(function ($query){
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
                    if ($user->can('course-lecture-video-edit')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = '<button class="custom-btn btn btn-primary btn-modal-view" data-url="'.route('admin.courses.lectures.videos.edit' , ['video' => $row['id']]).'" style="margin-left:5px;">تعديل</a>';
                        }
                    }
                    if ($user->can('course-lecture-video-delete')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.courses.lectures.videos.destroy' , ['video' => $row['id']]).'">حذف</button>';
                        }else{
                            $btn = $btn.'<button class="custom-btn btn btn-success restore-btn" data-url="'.route('admin.courses.lectures.videos.restore' , ['id' => $row['id']]).'" style="margin-left:5px;">إستعاده</button>';
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.courses.lectures.videos.force_delete' , ['id' => $row['id']]).'">حذف نهائي</button>';
                        }
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.courses.lectures.videos.index' , compact('id' , 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CourseLecture $id
     * @param  CourseLectureVideoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseLectureVideoRequest $request , $id)
    {
        try {
            $request->store($id);

            return add_response();
        } catch (\Throwable $th) {

            // dd($th->getMessage());
            return error_response();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CourseLectureVideo  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseLectureVideo $video)
    {
        $lecture = CourseLecture::findOrFail($video->course_lecture_id);
        $type = $lecture->course['price'] == 'null' ? 'free' : 'paid';

        return view('admin.pages.courses.lectures.videos.edit' ,compact('video' , 'type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CourseLectureVideoRequest  $request
     * @param  CourseLectureVideo $video
     * @return \Illuminate\Http\Response
     */
    public function update(CourseLectureVideoRequest $request, CourseLectureVideo $video)
    {
        try {
            $request->update($video);

            return update_response();
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CourseLectureVideo $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseLectureVideo $video)
    {
        $video->delete();

        return redirect()->back();
    }

    /**
     * restore specified resource from storage
     *
     * @param CourseLectureVideo $course
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $video = CourseLectureVideo::withTrashed()->find($id);
        $video->restore();

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
        $video = CourseLectureVideo::withTrashed()->find($id);
        $video->forceDelete();

        return redirect()->back();
    }
}
