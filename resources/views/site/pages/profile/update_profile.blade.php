@extends('site.layouts.master')
@section('content')
    <!-- Section ==========================================-->
    <section class="page_head">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>الملف الشخصى</h3>
                    <ul>
                        <li>
                            <a href="{{ route('site.index') }}"> الرئيسية </a>
                        </li>
                        <li>الملف الشخصى</li>
                    </ul>
                </div>
                <!--End Col-->
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
    <!-- Section ==========================================-->
    <section class="section_color profile">
        <div class="container">
            <form class="row ajax-form" method="put" action="{{ route('site.profile.update') }}">
                @method('put')
                @csrf
                @include('site.pages.profile.templates.sidebar')
                <div class="col-lg-9">
                    <div class="box">
                        <div class="box_title">
                            <i class="icon icon-user"></i>
                            الملف الشخصى
                        </div>
                        <div class="row profile_form">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label> الأسم بالكامل <sup>*</sup> </label>
                                    <input class="form-control" type="text" value="{{ $user->name }}" name="name" />
                                </div>
                            </div>
                            <!--End Col-->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label> رقم الهاتف <sup>*</sup> </label>
                                    <input class="form-control" type="text" value="{{ $user->phone }}" name="phone" />
                                </div>
                            </div>
                            <!--End Col-->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label> البريد الألكترونى <sup>*</sup></label>
                                    <input class="form-control" type="email" value="{{ $user->email }}" name="email" />
                                </div>
                            </div>
                            <!--End Col-->
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label> العمر <sup>*</sup></label>
                                    <input type="text" class="form-control" value="{{ $user->age }}" name="age" />
                                </div>
                                <!--End Form Group-->
                            </div>
                            <!--End Col-->
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label> الدولة <sup>*</sup></label>
                                    <input type="text" class="form-control" value="{{ $user->country }}"
                                        name="country" />
                                </div>
                                <!--End Form Group-->
                            </div>
                            <!--End Col-->
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label>المدينة <sup>*</sup></label>
                                    <input type="text" class="form-control" value="{{ $user->city }}" name="city" />
                                </div>
                                <!--End Form Group-->
                            </div>
                            <!--End Col-->
                            <div class="col-12">
                                <div class="form-group">
                                    <label>العنوان <sup>*</sup></label>
                                    <input type="text" class="form-control" value="{{ $user->address }}"
                                        name="address" />
                                </div>
                                <!--End Form Group-->
                            </div>
                            <!--End Col-->
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label> رابط الفيسبوك :</label>
                                    <input type="url" class="form-control" value="{{ $user->facebook }}"
                                        name="facebook" />
                                </div>
                                <!--End Form Group-->
                            </div>
                            <!--End Col-md-6-->
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label> رابط الأنستجرام :</label>
                                    <input type="url" class="form-control" value="{{ $user->instagram }}"
                                        name="instagram" />
                                </div>
                                <!--End Form Group-->
                            </div>
                            <!--End Col-md-6-->
                        </div>
                        <!--End Col-md-6-->
                        <div class="col-md-12 col-sm-12 text-center">
                            <button class="link" type="submit">
                                <i class="fa fa-save"></i> حفظ التعديلات
                            </button>
                        </div>
                        <!--End Col-md-6-->
                    </div>
                </div>
                <!--End Col-->
            </form>
            <!--End Row-->
        </div>
    </section>
@endsection
@push('js')
    <script>
        $(document).on('submit', '.ajax-form', function() {
            var form = $(this);
            var url = form.attr('action');
            var formData = new FormData(form[0]);
            form.find(":submit").attr('disabled', true).html('<i class="fa fa-save"></i> إنتظر');

            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    notification("success", response, "fas fa-check");
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                },
                error: function(jqXHR) {
                    var response = $.parseJSON(jqXHR.responseText);

                    notification("danger", response, "fas fa-times");
                    form.find(":submit").attr('disabled', false).html(
                        '<i class="fa fa-save"></i> حفظ التعديلات');
                }
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                }
            });
            return false;
        });
    </script>
@endpush
