@extends('admin.layouts.master')
<!-- remove ajax -->
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>الدورات</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">لوحة المراقبة</a>
                            </li>
                            <li class="breadcrumb-item active">الدورات</li>
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
                                <h3 class="card-title">تعديل بيانات الدورة</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="post" action="{{ route('admin.courses.update', ['course' => $course->id]) }}"
                                id="courseform">
                                @csrf
                                @method('post')
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-6 text-center">
                                            <img src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $course->image, \Carbon\Carbon::now()->addMinutes(120)) }}"
                                                width="300">
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>صورة الدوره الخارجية </label>
                                                <input type="file" class="jfilestyle" name="image" />
                                                <div class="text-danger">برجاء الملاحظه أن الأبعاد القياسية للصوره
                                                    يجب ان تكون : 740 * 440</div>
                                            </div>

                                            <div class="form-group ">
                                                @if ($course->price == null)
                                                    <label>رابط الفيديو التعريفي للدورة</label>
                                                    <input type="text" class="form-control" name="video"
                                                        value="{{ $course->video }}">
                                                @else
                                                    <label>إرفق الفيديو </label>
                                                    <input type="file" class="jfilestyle" name="video" />
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group ">
                                                <label>عنوان الدورة</label>
                                                <input type="text" class="form-control" name="name"
                                                    value="{{ $course->translate('ar')->name }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group ">
                                                <label>عنوان الرابط في ال url</label>
                                                <input type="text" class="form-control" name="slug"
                                                    value="{{ $course->slug }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group ">
                                                <label>تصنيف الدورة</label>
                                                <select class="form-control" name="course_category_id">
                                                    <option value="0">إختر التصنيف</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ $course->course_category_id == $category->id ? 'selected' : '' }}>
                                                            {{ $category->translate('ar')->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group ">
                                                <label>المنتجات المتعلقه بالدورة</label>
                                                <select class="form-control select2" multiple name="products[]">
                                                    <option value="0" disabled>إختر المنتج</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}"
                                                            {{ $course->products->contains('product_id', $product->id) ? 'selected' : '' }}>
                                                            {{ $product->translate('ar')->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group ">
                                                <label>مستوي الدورة</label>
                                                <select class="form-control" name="level">
                                                    <option value="0">إختر المستوي</option>
                                                    <option value="1" {{ $course->level == '1' ? 'selected' : '' }}>مبتدئ
                                                    </option>
                                                    <option value="2" {{ $course->level == '2' ? 'selected' : '' }}>متقدم
                                                    </option>
                                                    <option value="3" {{ $course->level == '3' ? 'selected' : '' }}>محترف
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        @if ($course->price)
                                            <div class="col-6">
                                                <div class="form-group ">
                                                    <label>سعر الدورة</label>
                                                    <input type="number" class="form-control" name="price"
                                                        value="{{ $course->price }}">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group ">
                                                    <label>التخفيض الخاص بالدورة</label>
                                                    <input type="number" class="form-control" name="discount"
                                                        value="{{ $course->discount }}">
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-12">
                                            <div class="form-group ">
                                                <label>عن الدورة</label>
                                                <textarea class="form-control" name="description" rows="7">{{ $course->translate('ar')->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group ">
                                                <label>متطلبات الدورة</label>
                                                <textarea class="form-control" name="requirements" rows="7">{{ $course->translate('ar')->requirements }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group ">
                                                <label>مميزات الدورة</label>
                                                <textarea class="form-control" name="advantages" rows="7">{{ $course->translate('ar')->advantages }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        @if ($course->lecturer_image)
                                            <div class="col-6 text-center">
                                                <img src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $course->lecturer_image, \Carbon\Carbon::now()->addMinutes(120)) }}"
                                                    width="100">
                                            </div>
                                        @endif

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>صورة المحاضر </label>
                                                <input type="file" class="jfilestyle" name="lecturer_image" />

                                                <div class="text-danger">برجاء الملاحظه أن الأبعاد القياسية للصوره
                                                    يجب ان تكون : 100 * 100</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group ">
                                                <label>إسم المحاضر</label>
                                                <input type="text" class="form-control" name="lecturer_name"
                                                    value="{{ $course->translate('ar')->lecturer_name }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group ">
                                                <label>تخصص المحاضر</label>
                                                <input type="text" class="form-control" name="lecturer_speciality"
                                                    value="{{ $course->translate('ar')->lecturer_speciality }}">
                                            </div>
                                        </div>

                                        <div class=" col-12">
                                            <div class="form-group">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger"
                                                        role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                        aria-valuemax="100" style="width: 0%"></div>
                                                </div>
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
@push('js')
    <script>
        $(document).on('change', '#price-input', function() {
            if ($(this).val() == '0') {
                $('#price-div').css('display', 'contents');
            } else {
                $('#price-div').css('display', 'none');
                $('input[name="price"]').val("");
                $('input[name="discount"]').val("");
            }
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script>
        $(function() {
            $(document).ready(function() {
                $('#courseform').ajaxForm({
                    beforeSend: function() {
                        var percentage = '0';
                        $('#courseform').find(":submit").attr('disabled', true).html(
                            'برجاء الإنتظار');
                    },
                    uploadProgress: function(event, position, total, percentComplete) {
                        var percentage = percentComplete;
                        $('.progress .progress-bar').css("width", percentage + '%', function() {
                            return $(this).attr("aria-valuenow", percentage) + "%";
                        })
                    },
                    success: function(response) {
                        notification("success", response, "fas fa-check");
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        var response = $.parseJSON(xhr.responseText);
                        notification("danger", response, "fas fa-times");
                        $('#courseform').find(":submit").attr('disabled', false).html('حفظ');
                    },
                    complete: function(xhr) {
                        console.log('File has uploaded');
                    }
                });
            });
        });
    </script>
@endpush
