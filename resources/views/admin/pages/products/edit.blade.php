@extends('admin.layouts.master')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>خامات وأدوات</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">لوحة المراقبة</a>
                            </li>
                            <li class="breadcrumb-item active">خامات وأدوات</li>
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
                                <h3 class="card-title">تعديل بيانات المنتج</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="put" action="{{ route('admin.products.update', ['product' => $product->id]) }}"
                                class="ajax-form">
                                @csrf
                                @method('put')
                                <div class="card-body row">
                                    <div class="col-6 text-center">
                                        {{-- <img src="{{ get_image($product->image, 'products') }}" width="100"> --}}
                                        <img src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $product->image, \Carbon\Carbon::now()->addMinutes(120)) }}"
                                            width="100">
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>إرفق الصورة </label>
                                            <input type="file" class="jfilestyle" name="image" />
                                            <div class="text-danger">برجاء الملاحظه أن الأبعاد القياسية للصوره
                                                يجب ان تكون : 1000 * 1000</div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group ">
                                            <label>إسم المنتج</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $product->translate('ar')->name }}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>عنوان المنتج في ال url</label>
                                            <input type="text" class="form-control" name="slug"
                                                value="{{ $product->slug }}">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group ">
                                            <label>القسم</label>
                                            <select class="form-control" name="product_category_id">
                                                <option value="0">إختر القسنم</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $product->product_category_id == $category->id ? 'selected' : '' }}>
                                                        {{ $category->translate('ar')->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group ">
                                            <label>سعر المنتج</label>
                                            <input type="number" class="form-control" name="price"
                                                value="{{ $product->price }}">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group ">
                                            <label>الكمية المتاحة من المنتج</label>
                                            <input type="number" class="form-control" name="quantity"
                                                value="{{ $product->quantity }}">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>وصف المنتج</label>
                                            <textarea class="form-control tiny-editor" name="description">{{ $product->translate('ar')->description }}</textarea>
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
