@extends('admin.layouts.master')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>إعدادات الموقع</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">لوحة المراقبة</a>
                            </li>
                            <li class="breadcrumb-item active">إعدادات الموقع</li>
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
                                <h3 class="card-title">تعديل إعدادات الموقع</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="put" action="{{ route('admin.settings.update') }}" class="ajax-form">
                                @csrf
                                @method('put')
                                <div class="card-body row">
                                    <div class="col-6">
                                        <div class="form-group ">
                                            <label>البريد الإلكتروني</label>
                                            <input type="text" class="form-control" name="email"
                                                value="{{ $settings->email }}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>رقم الهاتف</label>
                                            <input type="text" class="form-control" name="phone"
                                                value="{{ $settings->phone }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>رابط الخريطه</label>
                                            <input type="text" class="form-control" name="map"
                                                value="{{ $settings->map }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>سياسة الخصوصية</label>
                                            <textarea class="form-control tiny-editor"
                                                name="privacy">{{ $settings->translate('ar')->privacy }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>الشروط والأحكام</label>
                                            <textarea class="form-control tiny-editor"
                                                name="terms">{{ $settings->translate('ar')->terms }}</textarea>
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
