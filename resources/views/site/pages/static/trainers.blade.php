@extends('site.layouts.master')
@section('content')
    <!-- Section ==========================================-->
    <section class="page_head">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>سـجـل كـمـدرب</h3>
                    <ul>
                        <li>
                            <a href="{{ route('site.index') }}"> الرئيسية </a>
                        </li>
                        <li>سـجـل كـمـدرب</li>
                    </ul>
                </div>
                <!--End Col-->
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
    <!--End Section-->
    <!-- Section ==========================================-->
    <section class="section_color courses">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form class="teacher_form" method="post" action="{{ route('site.trainers') }}">
                        @csrf
                        @method('post')
                        <div class="row">
                            <div class="col-12 text-center">
                                <div class="section_title">
                                    <h3>سجل معنا كمدرب</h3>
                                    <p>جعل حياة الناس أفضل من خلال الإبداع</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> الأسم بالكامل <sup>*</sup></label>
                                    <input type="text" class="form-control" name="name" />
                                </div>
                                <!--End Form Group-->
                            </div>
                            <!--End Col-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>رقم الهاتف<sup>*</sup></label>
                                    <input type="text" class="form-control" name="phone" />
                                </div>
                                <!--End Form Group-->
                            </div>
                            <!--End Col-->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>البريد الألكترونى</label>
                                    <input type="email" class="form-control" name="email" />
                                </div>
                                <!--End Form Group-->
                            </div>
                            <!--End Col-->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>السن<sup>*</sup></label>
                                    <input type="text" class="form-control" name="age" />
                                </div>
                                <!--End Form Group-->
                            </div>
                            <!--End Col-->

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label> المحافظة <sup>*</sup></label>
                                    <input type="text" class="form-control" name="government" />
                                </div>
                                <!--End Form Group-->
                            </div>
                            <!--End Col-->

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>المدينة أو المركز<sup>*</sup></label>
                                    <input type="text" class="form-control" name="city" />
                                </div>
                                <!--End Form Group-->
                            </div>
                            <!--End Col-->

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>القرية أو المنطقة<sup>*</sup></label>
                                    <input type="text" class="form-control" name="state" />
                                </div>
                                <!--End Form Group-->
                            </div>
                            <!--End Col-->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label> هل سبق لك تنفيذ دورات تدريبية<sup>*</sup></label>
                                    <div class="radio_item">
                                        <input type="radio" name="previous_experience" id="yes" value="yes" />
                                        <label for="yes"> نعم </label>
                                    </div>
                                    <div class="radio_item">
                                        <input type="radio" name="previous_experience" id="no" value="no" />
                                        <label for="no"> لا </label>
                                    </div>
                                </div>
                                <!--End Form Group-->
                            </div>
                            <!--End Col-->
                            <div class="col-md-12" id="experince-input" style="display:none;">
                                <div class="form-group">
                                    <label>
                                        اذكر الدورات وأماكن التدريب
                                        <sup>*</sup></label>
                                    <textarea class="form-control" name="experience"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>
                                        المحتوى الذى تود تقديم دورات تدريبية فيه
                                        <sup>*</sup></label>
                                    <textarea class="form-control" name="content"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>
                                        المؤهل العلمى
                                        <sup>*</sup></label>
                                    <input class="form-control" type="text" name="qualification" />
                                </div>
                            </div>

                            <hr class="w-100" />
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> رابط الفيسبوك</label>
                                    <input type="url" class="form-control" name="facebook" />
                                </div>
                                <!--End Form Group-->
                            </div>
                            <!--End Col-->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> رابط اليوتيوب</label>
                                    <input type="url" class="form-control" name="youtube" />
                                </div>
                                <!--End Form Group-->
                            </div>
                            <!--End Col-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> رابط الأنستجرام </label>
                                    <input type="url" class="form-control" name="instagram" />
                                </div>
                                <!--End Form Group-->
                            </div>
                            <!--End Col-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> السيرة الذاتية</label>
                                    <div class="upload_item">
                                        <input type="file" name="cv" />
                                        <span> إختار ملف </span>
                                    </div>
                                </div>
                                <!--End Form Group-->
                            </div>
                            <!--End Col-->
                            <div class="w-100 h-15"></div>
                            <div class="col-12 text-center">
                                <button class="link" type="submit">
                                    <span> ارسل طلبك الآن </span>
                                </button>
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
        $(document).on('submit', '.teacher_form', function() {
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
                    notification("success", response, "fas fa-check");
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                },
                error: function(jqXHR) {
                    var response = $.parseJSON(jqXHR.responseText);

                    notification("danger", response, "fas fa-times");
                    form.find(":submit").attr('disabled', false).html('<span> ارسل طلبك الآن </span>');
                }
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                }
            });
            return false;
        });

        $('input[type=radio][name=previous_experience]').change(function() {
            if (this.value == 'yes') {
                $('#experince-input').css('display', 'block');
            } else if (this.value == 'no') {
                $('#experince-input').css('display', 'none');
            }
        });
    </script>
@endpush
