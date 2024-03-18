@extends('site.layouts.master')
@section('content')
    <section class="page_head">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form class="login wide login-form" action="{{ route('site.password.update') }}" method="post">
                        @csrf
                        @method('post')
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="row">
                            <div class="col-12">
                                <div class="section_title">
                                    <h3>كلمة المرور الجديدة</h3>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email"
                                        value="{{ $email ?? old('email') }}" readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="كلمة المرور"
                                        name="password" />
                                    <i class="icon icon-lock"></i>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="تأكيد كلمة المرور"
                                        name="password_confirmation" />
                                    <i class="icon icon-lock"></i>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group text-center">
                                    <button class="link" type="submit">
                                        <span> تأكيد كلمة المرور </span>
                                    </button>
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
                    notification("success", "تم تغيير كلمه السر بنجاح", "fas fa-check");
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
                    form.find(":submit").attr('disabled', false).html(
                        "<span> تأكيد كلمة المرور </span>");
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
