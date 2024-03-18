@extends('site.layouts.master')
@section('content')
    <!-- Section ==========================================-->
    <section class="page_head">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>المؤسسات والشركات</h3>
                    <ul>
                        <li>
                            <a href="{{ route('site.index') }}"> الرئيسية </a>
                        </li>
                        <li>المؤسسات والشركات</li>
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
    <section class="section_color pt-0">
        <div class="container-fluid">
            <div class="row">
                <div class="owl-carousel owl-theme companies_slider">
                    @foreach ($images as $image)
                        <div class="item">
                            <img
                                src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $image->image, \Carbon\Carbon::now()->addMinutes(120)) }}" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="text course_sticky_block">
                        <h3>الشركات :</h3>
                        <p>لدينا محتويات ترفيهية وتفاعلية متنوعة للموظفين وأسرهم .</p>
                        <h3>المؤسسات :</h3>
                        <p>
                            لدينا محتويات متنوعة تتمكن المؤسسات من خلالها بناء وحدة إنتاجية
                            كاملة بكافة المهارات المطلوبة لمختلف أفراد فريق العمل .
                        </p>
                    </div>
                </div>
                <div class="col-lg-7">
                    <form class="teacher_form ajax-form" method="post" action="{{ route('site.companies') }}">
                        @csrf
                        @method('post')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> الاسم بالكامل <sup>*</sup></label>
                                    <input type="text" class="form-control" name="name" />
                                </div>
                                <!--End Form Group-->
                            </div>
                            <!--End Col-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> اسم الشركة أو المؤسسة <sup>*</sup></label>
                                    <input type="text" class="form-control" name="company_name" />
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
                                    <label>البريد الألكترونى<sup>*</sup></label>
                                    <input type="email" class="form-control" name="email" />
                                </div>
                                <!--End Form Group-->
                            </div>
                            <!--End Col-->
                            <div class="col-12">
                                <div class="form-group">
                                    <label> عدد الموظفين<sup>*</sup></label>
                                    <div class="radio_item d-block w-100">
                                        <input type="radio" name="no_of_employees" id="ce1" value="1-25" />
                                        <label for="ec1"> 1-25 </label>
                                    </div>
                                    <div class="radio_item d-block w-100">
                                        <input type="radio" name="no_of_employees" id="ec2" value="26 - 100" />
                                        <label for="ec2"> 26 - 100</label>
                                    </div>
                                    <div class="radio_item d-block w-100">
                                        <input type="radio" name="no_of_employees" id="ec3" value="101 - 500" />
                                        <label for="ec3"> 101 - 500</label>
                                    </div>
                                    <div class="radio_item d-block w-100">
                                        <input type="radio" name="no_of_employees" id="ec4" value="500 - 1000" />
                                        <label for="ec4"> 500 - 1000</label>
                                    </div>
                                    <div class="radio_item d-block w-100">
                                        <input type="radio" name="no_of_employees" id="ec5" value="1000 - 5000" />
                                        <label for="ec5"> 1000 - 5000</label>
                                    </div>
                                    <div class="radio_item d-block w-100">
                                        <input type="radio" name="no_of_employees" id="ec6" value="+5000" />
                                        <label for="ec6"> +5000</label>
                                    </div>
                                </div>
                                <!--End Form Group-->
                            </div>
                            <!--End Col-->
                            <div class="col-12">
                                <div class="form-group">
                                    <label>أخبرنا عن شركتك أو مؤسستك <sup>*</sup></label>
                                    <textarea class="form-control" name="description"></textarea>
                                </div>
                                <!--End Form Group-->
                            </div>
                            <!--End Col-->
                            <div class="w-100 h-15"></div>
                            <div class="col-12 text-center">
                                <button class="link" type="submit">
                                    <span> ارسـل طـلـبـك </span>
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
        $(document).on('submit', '.ajax-form', function() {
            var form = $(this);
            var url = form.attr('action');
            var formData = new FormData(form[0]);
            form.find(":submit").attr('disabled', true).html('<span> إنتظر</span>');

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
                    form.find(":submit").attr('disabled', false).html('<span> ارسـل طـلـبـك </span>');
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
