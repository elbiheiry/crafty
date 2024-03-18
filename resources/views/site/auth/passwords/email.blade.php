@extends('site.layouts.master')
@section('content')
    <section class="page_head">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form class="login wide login-form" method="post" action="{{ route('site.password.email') }}">
                        @csrf
                        @method('post')
                        <div class="row">
                            <div class="col-12">
                                <div class="section_title">
                                    <h3>إعادة تعيين كلمة المرور</h3>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label> إدخال البريد الألكترونى لتغيير كلمة المرور</label>
                                    <input type="email" class="form-control" placeholder="البريد الألكترونى "
                                        name="email" />
                                    <i class="icon icon-mail"></i>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group text-center">
                                    <button class="link" type="submit">
                                        <span> إرسال </span>
                                    </button>
                                    <div class="w-100"></div>
                                    <a href="{{ route('site.login') }}"> العودة لتسجيل الدخول </a>
                                </div>
                            </div>
                        </div>
                    </form>
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
        $(document).on('submit', '.login-form', function() {
            var form = $(this);
            var url = form.attr('action');
            var formData = new FormData(form[0]);
            form.find(":submit").attr('disabled', true).html('<span>إنتظر</span>');

            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    notification("success", "تم إرسال رسالة الي بريدك الإلكتروني", "fas fa-check");
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                },
                error: function(jqXHR) {
                    var response = $.parseJSON(jqXHR.responseText);
                    var errors = [];
                    $.each(response.errors, function(index, value) {
                        errors.push(value);
                    });
                    notification("danger", errors[0], "fas fa-times");
                    form.find(":submit").attr('disabled', false).html("<span> إرسال </span>");
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
