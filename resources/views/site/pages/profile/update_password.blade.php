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
            <div class="row">
                @include('site.pages.profile.templates.sidebar')
                <div class="col-lg-9">
                    <div class="box">
                        <div class="box_title">
                            <i class="icon icon-lock"></i>
                            الرقم السرى
                        </div>
                        <form class="profile_form ajax-form" method="put"
                            action="{{ route('site.profile.update_password') }}">

                            <div class="row col-md-6 mr-0">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label> كلمة المرور القديمة </label>
                                        <input type="password" class="form-control" name="old_password" />
                                    </div>
                                    <!--End Form Group-->
                                </div>
                                <!--End Col-md-6-->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label> كلمة المرور الجديدة </label>
                                        <input type="password" class="form-control" name="password" />
                                    </div>
                                    <!--End Form Group-->
                                </div>
                                <!--End Col-md-6-->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label> تأكيد كلمة المرور الجديدة </label>
                                        <input type="password" class="form-control" name="password_confirmation" />
                                    </div>
                                    <!--End Form Group-->
                                </div>
                                <!--End Col-md-6-->
                                <div class="col-12">
                                    <button class="link" type="submit">
                                        <i class="fa fa-save"></i> حفظ التعديلات
                                    </button>
                                </div>
                                <!--End Col-md-6-->
                            </div>
                            @csrf
                            @method('put')
                        </form>

                    </div>
                </div>
                <!--End Col-->
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
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
