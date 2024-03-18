<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Product;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param string $type
     * @return \Illuminate\Http\Response
     */
    public function index($type)
    {
        $user = auth()->user();
        if (request()->ajax()) {
            if ($type == 'free') {
                $data = Course::withTrashed()->where('price' , null)->get()->map(function ($query){
                    return [
                        'id' => $query->id,
                        'name' => $query->translate('ar')->name,
                        'category' => $query->category->translate('ar')->name,
                        'slug' => $query->slug,
                        'trashed' => $query->trashed() ? 'trashed' : '',
                        'created_at' => $query->created_at->format('d-m-Y')
                    ];
                });
            }else{
                $data = Course::withTrashed()->where('price' , '!=' , null)->get()->map(function ($query){
                    return [
                        'id' => $query->id,
                        'name' => $query->translate('ar')->name,
                        'category' => $query->category->translate('ar')->name,
                        'price' => $query->price == 0 ? 'مجاني' : $query->price,
                        'slug' => $query->slug,
                        'level' => $query->get_level(),
                        'trashed' => $query->trashed() ? 'trashed' : '',
                        'created_at' => $query->created_at->format('d-m-Y')
                    ];
                });
            }
            
            return datatables()->of($data)
                ->addColumn('name' , function ($row){
                    // dd($row);
                    return '<a style="color:blue;" href="'.route('site.course' , ['id' => $row['id'] , 'slug' => $row['slug']]).'">'.$row['name'].'</a>';
                })
                ->addColumn('action', function($row) use ($user){
                    $btn = '';
                    if ($user->can('course-edit')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = '<a class="custom-btn btn btn-primary" href="'.route('admin.courses.edit' , ['course' => $row['id']]).'" style="margin-left:5px;">تعديل</a>';
                        }
                    }
                    if ($user->can('course-delete')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.courses.destroy' , ['course' => $row['id']]).'" style="margin-left:5px;">حذف</button>';
                        }else{
                            $btn = $btn.'<button class="custom-btn btn btn-success restore-btn" data-url="'.route('admin.courses.restore' , ['id' => $row['id']]).'" style="margin-left:5px;">إستعاده</button>';
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.courses.force_delete' , ['id' => $row['id']]).'">حذف نهائي</button>';
                        }
                    }
                    if ($user->can('course-lecture-list')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = $btn.'<a class="custom-btn btn btn-success" href="'.route('admin.courses.lectures.index' , ['id' => $row['id']]).'" style="margin-left:5px;">المحاضرات</a>';
                        }
                    }
                    return $btn;
                })
                ->rawColumns(['name' , 'action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.courses.index');
    }

    /**
     * Show the form for creating the specified resource.
     *
     * @param string $type
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        $categories = CourseCategory::all()->sortByDesc('id');
        $products = Product::all()->sortByDesc('id');

        return view('admin.pages.courses.create' , compact('categories' , 'products' , 'type'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  CourseRequest  $request
     * @param string $type
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request , $type)
    {
        try {
            $request->store($type);

            return add_response();
        } catch (\Throwable $th) {
         dd($th->getMessage());
            return error_response();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        $categories = CourseCategory::all()->sortByDesc('id');
        $products = Product::all()->sortByDesc('id');

        return view('admin.pages.courses.edit' ,compact('course' , 'categories' , 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CourseRequest  $request
     * @param  Course $course
     * @return \Illuminate\Http\Response
     */
    public function update(CourseRequest $request, Course $course)
    {
        try {
            $request->update($course);

            return update_response();
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            return error_response();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Course $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->back();
    }

    /**
     * restore specified resource from storage
     *
     * @param Course $course
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $course = Course::withTrashed()->find($id);
        $course->restore();

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
        $course = Course::withTrashed()->find($id);
        image_delete($course->image , 'courses');
        image_delete($course->lecturer_image , 'courses');
        $course->forceDelete();

        return redirect()->back();
    }
}
