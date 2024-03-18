@extends('admin.layouts.master')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>من نحن</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">لوحة المراقبة</a>
                            </li>
                            <li class="breadcrumb-item active">من نحن</li>
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
                                <h3 class="card-title">تعديل من نحن</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="put" action="{{ route('admin.about.update') }}" class="ajax-form">
                                @csrf
                                @method('put')
                                <div class="card-body ">
                                    <div class="col-12">
                                        <img src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $about->image, \Carbon\Carbon::now()->addMinutes(120)) }}"
                                            width="100">
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>إرفق الصوره </label>
                                                <input type="file" class="jfilestyle" name="image" />
                                                <div class="text-danger">برجاء الملاحظه أن الأبعاد القياسية للصوره
                                                    يجب ان تكون : 540 * 430</div>
                                            </div>

                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>العنوان</label>
                                                <input type="text" class="form-control" name="title"
                                                    value="{{ $about->translate('ar')->title }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>الوصف</label>
                                                <textarea class="form-control tiny-editor" name="description">{{ $about->translate('ar')->description }}</textarea>
                                            </div>
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
