<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\Course;
use App\Models\Product;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:article-create')->only('create');
        $this->middleware('permission:article-edit')->only('edit');
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
            $data = Article::withTrashed()->get()->map(function ($query){
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
                    if ($user->can('article-edit')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = '<a class="custom-btn btn btn-primary" href="'.route('admin.articles.edit' , ['article' => $row['id']]).'" style="margin-left:5px;">تعديل</a>';
                        }
                    }
                    if ($user->can('article-delete')) {
                        if(!$row['trashed'] == 'trashed'){
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.articles.destroy' , ['article' => $row['id']]).'">حذف</button>';
                        }else{
                            $btn = $btn.'<button class="custom-btn btn btn-success restore-btn" data-url="'.route('admin.articles.restore' , ['id' => $row['id']]).'" style="margin-left:5px;">إستعاده</button>';
                            $btn = $btn.'<button class="custom-btn btn btn-danger delete-btn" data-url="'.route('admin.articles.force_delete' , ['id' => $row['id']]).'">حذف نهائي</button>';
                        }
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.articles.index');
    }

    /**
     * Show the form for creating the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all()->sortByDesc('id');
        $courses = Course::all()->sortByDesc('id');

        return view('admin.pages.articles.create' ,compact('products' , 'courses'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  ArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
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
     * @param  Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $products = Product::all()->sortByDesc('id');
        $courses = Course::all()->sortByDesc('id');

        return view('admin.pages.articles.edit' ,compact('article','products' , 'courses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ArticleRequest  $request
     * @param  Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article)
    {
        try {
            $request->update($article);

            return update_response();
        } catch (\Throwable $th) {
            return error_response();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->back();
    }

    /**
     * restore specified resource from storage
     *
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $article = Article::withTrashed()->find($id);
        $article->restore();

        return redirect()->back();
    }

    /**
     * Delete the specified resource permanentely from storage
     *
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    public function force_delete($id)
    {
        $article = Article::withTrashed()->find($id);
        image_delete($article->inner_image , 'articles');
        image_delete($article->outer_image , 'articles');
        $article->forceDelete();

        return redirect()->back();
    }
}
