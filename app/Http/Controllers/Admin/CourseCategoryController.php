<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseCategoryRequest;
use App\Models\CourseCategory;
use Illuminate\Http\Request;

class CourseCategoryController extends Controller
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
            $data = CourseCategory::withTrashed()->get()->map(function ($query){
                return [
                    'id' => $query->id,
                    'name' => $query->translate('ar')->name,
                    'counter' => $query->courses()->count(),
                    'trashed' => $query->trashed() ? 'trashed' : '',
                    'created_at' => $query->created_at->format('d-m-Y')
                ];
            });
            return datatables()->of($data)
                ->addColumn('action', function($row) use ($user){
                    $btn = '';
                    if ($user->can('course-category-edit')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = '<button class="custom-btn btn btn-primary btn-modal-view" data-url="'.route('admin.courses.category.edit' , ['category' => $row['id']]).'" style="margin-left:5px;">تعديل</button>';
                        }
                    }
                    if ($user->can('course-category-delete')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.courses.category.destroy' , ['category' => $row['id']]).'">حذف</button>';
                        }else{
                            $btn = $btn.'<button class="custom-btn btn btn-success restore-btn" data-url="'.route('admin.courses.category.restore' , ['id' => $row['id']]).'" style="margin-left:5px;">إستعاده</button>';
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.courses.category.force_delete' , ['id' => $row['id']]).'">حذف نهائي</button>';
                        }
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.courses.category.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CourseCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseCategoryRequest $request)
    {
        try {
            $request->store();

            return add_response();
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return error_response();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CourseCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseCategory $category)
    {
        return view('admin.pages.courses.category.edit' ,compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CourseCategoryRequest  $request
     * @param  CourseCategory $category
     * @return \Illuminate\Http\Response
     */
    public function update(CourseCategoryRequest $request, CourseCategory $category)
    {
        try {
            $request->update($category);

            return update_response();
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CourseCategory $link
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseCategory $category)
    {
        $category->deleted_by = auth()->id();
        $category->save();
        $category->delete();

        return redirect()->back();
    }

    /**
     * restore specified resource from storage
     *
     * @param CourseCategory $category
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $category = CourseCategory::withTrashed()->find($id);
        $category->deleted_by = null;
        $category->save();
        $category->restore();

        return redirect()->back();
    }

    /**
     * Delete the specified resource permanentely from storage
     *
     * @param CourseCategory $category
     * @return \Illuminate\Http\Response
     */
    public function force_delete($id)
    {
        $category = CourseCategory::withTrashed()->find($id);
        image_delete($category->image , 'courses');
        foreach ($category->courses() as $key => $course) {
            image_delete($course->image , 'courses');
        }
        $category->forceDelete();

        return redirect()->back();
    }
}
