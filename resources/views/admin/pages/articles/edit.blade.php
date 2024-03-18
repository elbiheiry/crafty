@extends('admin.layouts.master')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>المدونه</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">لوحة المراقبة</a>
                            </li>
                            <li class="breadcrumb-item active">المدونه</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">تعديل بيانات المقال</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="put" action="{{ route('admin.articles.update', ['article' => $article->id]) }}"
                                class="ajax-form">
                                @csrf
                                @method('put')
                                <div class="card-body row">
                                    <div class="col-6 text-center">
                                        <img src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $article->inner_image, \Carbon\Carbon::now()->addMinutes(120)) }}"
                                            width="100">
                                    </div>
                                    <div class="col-6 text-center">
                                        <img src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $article->outer_image, \Carbon\Carbon::now()->addMinutes(120)) }}"
                                            width="100">
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>صورة المقال الداخلية </label>
                                            <input type="file" class="jfilestyle" name="inner_image" />
                                            <div class="text-danger">
                                                برجاء الملاحظه أن الأبعاد القياسية للصوره يجب ان تكون : 700 * 460
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>صورة المقال الخارجية </label>
                                            <input type="file" class="jfilestyle" name="outer_image" />
                                            <div class="text-danger">
                                                برجاء الملاحظه أن الأبعاد القياسية للصوره يجب ان تكون : 650 * 430
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group ">
                                            <label>عنوان المقال</label>
                                            <input type="text" class="form-control" name="title"
                                                value="{{ $article->translate('ar')->title }}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>عنوان المقال في ال url</label>
                                            <input type="text" class="form-control" name="slug"
                                                value="{{ $article->slug }}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>كلمات مختصره عن المقال</label>
                                            <input type="text" class="form-control" name="brief"
                                                value="{{ $article->translate('ar')->brief }}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group ">
                                            <label>المنتجات المتعلقه </label>
                                            <select class="form-control select2" multiple name="products[]">
                                                <option value="0" disabled>إختر المنتج</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}"
                                                        {{ $article->products->contains('product_id', $product->id) ? 'selected' : '' }}>
                                                        {{ $product->translate('ar')->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group ">
                                            <label>الدورات المتعلقه </label>
                                            <select class="form-control select2" multiple name="courses[]">
                                                <option value="0" disabled>إختر الدوره</option>
                                                @foreach ($courses as $course)
                                                    <option value="{{ $course->id }}"
                                                        {{ $article->courses->contains('course_id', $course->id) ? 'selected' : '' }}>
                                                        {{ $course->translate('ar')->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>وصف المقال</label>
                                            <textarea class="form-control tiny-editor" name="description">{{ $article->translate('ar')->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">حفظ</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
