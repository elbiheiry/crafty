@extends('site.layouts.master')
@section('content')
    <!-- Section==========================================-->
    <section class="page_head">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>تواصل معنا</h3>
                    <ul>
                        <li>
                            <a href="{{ route('site.index') }}"> الرئيسية </a>
                        </li>
                        <li>تواصل معنا</li>
                    </ul>
                </div>
                <!--End Col-->
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
    <!--End Section-->
    <!-- Section==========================================-->
    <section class="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <form method="post" action="{{ route('site.contact') }}" class="contact-form">
                        @csrf
                        @method('post')
                        <div class="row">
                            <div class="col-12">
                                <div class="section_title">
                                    <h3>لا تتردد في التحدث إلينا إذا كان لديك أي أسئلة.</h3>

                                    <p>نسعى للإجابة في غضون 24 ساعة.</p>
                                </div>
                            </div>
                            <!--End section Title-->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label> الأسم بالكامل</label>
                                    <input type="text" class="form-control" placeholder="الأسم بالكامل" name="name" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> رقم الهاتف </label>
                                    <input type="text" class="form-control" placeholder=" رقم الهاتف " name="phone" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> عنوان الرسالة </label>
                                    <input type="text" class="form-control" placeholder=" عنوان الرسالة "
                                        name="subject" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label> الرسالة </label>
                                    <textarea class="form-control" placeholder="الرسالة" name="message"></textarea>
                                </div>
                            </div>
                        </div>

                        <button class="link" type="submit">
                            <i class="icon icon-mail"></i>
                            إرسال الرسالة
                        </button>
                    </form>
                </div>

                <div class="col-lg-4">
                    <div class="contact_info">
                        <a href="mailto:{{ $settings->email }}" class="address_item">
                            <h3><i class="icon icon-mail"></i> البريد الإلكترونى</h3>
                            <p>{{ $settings->email }}</p>
                        </a>

                        <a href="tel:{{ $settings->phone }}" class="address_item">
                            <h3><i class="icon icon-phone"></i> رقم الهاتف</h3>
                            <p>{{ $settings->phone }}</p>
                        </a>
                        <div class="address_item">
                            <h3><i class="icon icon-share"></i> تابعنا على</h3>
                            <ul class="social">
                                @foreach ($links as $link)
                                    <li>
                                        <a target="_blank" href="{{ $link->link }}"
                                            class="icon_link icon icon-{{ $link->name }}">
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!--End Col-->
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
    <!--End Section-->
@endsection
@push('js')
    <script>
        $(document).on('submit', '.contact-form', function() {
            var form = $(this);
            var url = form.attr('action');
            var formData = new FormData(form[0]);
            form.find(":submit").attr('disabled', true).html('<i class="icon icon-mail"></i> إنتظر');

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
                        '<i class="icon icon-mail"></i> إرسال الرسالة');
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
