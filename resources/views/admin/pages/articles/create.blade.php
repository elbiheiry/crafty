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
                                <h3 class="card-title">إضافه مقال جديد</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="post" action="{{ route('admin.articles.store') }}" class="ajax-form">
                                @csrf
                                @method('post')
                                <div class="card-body row">
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
                                            <input type="text" class="form-control" name="title">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>كلمات مختصره عن المقال</label>
                                            <input type="text" class="form-control" name="brief">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group ">
                                            <label>المنتجات المتعلقه</label>
                                            <select class="form-control select2" multiple name="products[]">
                                                <option value="0" disabled>إختر المنتج</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">
                                                        {{ $product->translate('ar')->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group ">
                                            <label>الدورات المتعلقه</label>
                                            <select class="form-control select2" multiple name="courses[]">
                                                <option value="0" disabled>إختر الدوره</option>
                                                @foreach ($courses as $course)
                                                    <option value="{{ $course->id }}">
                                                        {{ $course->translate('ar')->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>وصف المقال</label>
                                            <textarea class="form-control tiny-editor" name="description"></textarea>
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
