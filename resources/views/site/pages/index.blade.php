{{-- @extends('site.layouts.master')
@section('content')
    <!-- Section ==========================================-->
    <section class="main_section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="caption">
                        <h1>جعل حياة الناس أفضل من خلال الإبداع</h1>
                        <h3>
                            الوصول إلى أفضل الخبراء في العالم الذين يسهلون تعلم جديد
                            المهارات
                        </h3>
                        @if (auth()->guard('site')->guest())
                            <a href="{{ route('site.register') }}" class="link">
                                <span>
                                    <i class="icon icon-files"></i>
                                    اشترك الآن
                                </span>
                            </a>
                        @endif
                    </div>
                </div>
                <!--End Col-->
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
        <a href="#next" class="scroll_btn"></a>
    </section>
    <!--End Section-->
    <!-- Section ==========================================-->
    <section class="section_color courses" id="next">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-up" data-aos-delay="40">
                    <div class="section_title">
                        <h3>أحدث الدورات التدريبية</h3>
                        <p>
                            الوصول إلى أفضل الخبراء في العالم الذين يسهلون تعلم جديد
                            المهارات
                        </p>
                    </div>
                </div>
                <!--End Col-->
                @foreach ($courses as $course)
                    <div class="col-lg-4 col-md-6 col-sm-6" data-aos="fade-up" data-aos-delay="80">
                        <div class="course">
                            <div class="cover">
                                @if ($course->discount != 0 || $course->discount)
                                    <span class="status"> خصم {{ $course->discount }} </span>
                                @endif

                                <div class="act">
                                    <button class="icon_link icon icon-bookmark wishlist-btn"
                                        data-url="{{ route('site.course.wishlist', ['id' => $course->id]) }}"></button>
                                </div>
                                <a href="{{ route('site.course', ['id' => $course->id, 'slug' => $course->slug]) }}">
                                    <img
                                        src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $course->image,\Carbon\Carbon::now()->addMinutes(120)) }}" />
                                </a>
                            </div>

                            <div class="cont">
                                <span class="category">
                                    {{ $course->category->translate(app()->getLocale())->name }}
                                </span>
                                <span class="category"> {{ $course->get_level() }}</span>
                                <a href="{{ route('site.course', ['id' => $course->id, 'slug' => $course->slug]) }}"
                                    class="title">{{ $course->translate(app()->getLocale())->name }}</a>
                                <div class="inst">
                                    <img
                                        src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $course->lecturer_image,\Carbon\Carbon::now()->addMinutes(120)) }}" />
                                    {{ $course->translate(app()->getLocale())->lecturer_name }}
                                </div>
                            </div>
                            <div class="sub_info">
                                @if (!in_array($course->id, $course_ids))
                                    <button class="link add-to-cart"
                                        data-url="{{ route('site.course.cart.add', ['id' => $course->id]) }}">
                                        <span>
                                            <i class="icon icon-shopping-cart"></i>
                                            {{ $course->price_after_discount() }} جنيه
                                        </span>
                                    </button>
                                @endif

                                <span class="num_lesson">
                                    <i class="icon icon-eye"></i>
                                    {{ $course->views }}
                                </span>
                            </div>
                        </div>
                        <!--End Course-->
                    </div>
                @endforeach

                <div class="col-lg-12 text-center" data-aos="fade-up" data-aos-delay="400">
                    <a href="{{ route('site.courses') }}" class="link more">
                        <span> مشاهدة المزيد </span>
                    </a>
                </div>
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
    <!-- Section ==========================================-->
    <section class="tools">
        <div class="container">
            <div class="row">
                <div class="col-12 text-right" data-aos="fade-up" data-aos-delay="40">
                    <div class="section_title">
                        <h3>الخامات والأدوات</h3>
                        <p>
                            الوصول إلى أفضل الخبراء في العالم الذين يسهلون تعلم جديد
                            المهارات
                        </p>
                    </div>
                </div>
                <!--End Col-->
                <div class="col-12" data-aos="fade-up" data-aos-delay="80">
                    <div class="owl-carousel owl-theme tools_slider">
                        @foreach ($products as $product)
                            <div class="item">
                                <div class="tool_item">
                                    <a href="{{ route('site.product', ['id' => $product->id, 'slug' => $product->slug]) }}"
                                        class="cover">
                                             <img src="{{ get_image($product->image, 'products') }}" />
                                        <img
                                            src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $product->image,\Carbon\Carbon::now()->addMinutes(120)) }}" />
                                    </a>
                                    <div class="cont">
                                        <a
                                            href="{{ route('site.product', ['id' => $product->id, 'slug' => $product->slug]) }}">{{ $product->translate(app()->getLocale())->name }}</a>
                                        <p>{{ $product->price }} جنيه</p>
                                        <div class="w-100">
                                            <button class="icon_link icon icon-bookmark wishlist-btn"
                                                data-url="{{ route('site.product.wishlist', ['id' => $product->id]) }}"></button>
                                            <button class="link add-to-cart"
                                                data-url="{{ route('site.product.cart.add', ['id' => $product->id]) }}">
                                                <span>
                                                    <i class="icon icon-shopping-cart"></i>
                                                    إضافة للعربة
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!--End Tool -->
                            </div>
                        @endforeach
                    </div>
                </div>
                <!--End Col-->
                <div class="col-12 text-center" data-aos="fade-up" data-aos-delay="120">
                    <a href="{{ route('site.products') }}" class="link more">
                        <span> مشاهدة المزيد </span>
                    </a>
                </div>
                <!--End Col-->
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
    <!--End Section-->
    <!-- Section ==========================================-->
    <section class="features">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="40">
                    <div class="feature">
                        <i class="icon icon-video-camera"></i>
                        <h3>دورات دراسية مكثفة</h3>
                        <p>دورة سريعة ومكثفة لمدة يوم أو يومين سهلة وبسيطة وغير مكلفة</p>
                    </div>
                    <!--End  Feature-->
                </div>
                <!--End Col-->
                <div class="col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="80">
                    <div class="feature">
                        <i class="icon icon-user"></i>
                        <h3>تعليمات الخبراء</h3>
                        <p>دورة سريعة ومكثفة لمدة يوم أو يومين سهلة وبسيطة وغير مكلفة</p>
                    </div>
                    <!--End  Feature-->
                </div>
                <!--End Col-->
                <div class="col-md-4 col-sm-12" data-aos="fade-up" data-aos-delay="120">
                    <div class="feature">
                        <i class="icon icon-files"></i>
                        <h3>دبلومات دراسية كاملة</h3>
                        <p>استمتع بمجموعة متنوعة من الموضوعات الجديدة</p>
                    </div>
                    <!--End  Feature-->
                </div>
                <!--End Col-->
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
    <!--End Section-->
    <!-- Section ==========================================-->
    <section class="blog section_color">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-up" data-aos-delay="40">
                    <div class="section_title">
                        <h3>المدونة</h3>
                        <p>
                            الوصول إلى أفضل الخبراء في العالم الذين يسهلون تعلم جديد
                            المهارات
                        </p>
                    </div>
                </div>
                <!--End Col-->
                @foreach ($articles as $article)
                    <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="80">
                        <a href="{{ route('site.article', ['id' => $article->id, 'slug' => $article->slug]) }}"
                            class="blog_item">
                            <div class="cover">
                                 <img src="{{ get_image($article->outer_image, 'articles') }}" /> 
                                <img
                                    src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $article->outer_image,\Carbon\Carbon::now()->addMinutes(120)) }}" />
                            </div>
                            <div class="cont">
                                <h3>{{ $article->translate(app()->getLocale())->title }}</h3>
                                <p>{{ $article->translate(app()->getLocale())->brief }} ...</p>
                                <p class="text_link">
                                    مشاهدة المزيد
                                    <i class="icon icon-chevron-down"></i>
                                </p>
                            </div>
                        </a>
                        <!--End Blog-->
                    </div>
                @endforeach
                <div class="col-12 text-center" data-aos="fade-up" data-aos-delay="120">
                    <a href="{{ route('site.blog') }}" class="link more">
                        <span> مشاهدة المزيد </span>
                    </a>
                </div>
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
        @include('site.layouts.subscribe')
    </section>
    <!--End Section-->
@endsection
@push('js')
    <script>
        $(document).on('click', '.wishlist-btn', function() {
            var url = $(this).data('url');

            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    notification("success", response, "fas fa-check");
                },
                error: function(jqXHR) {
                    var response = $.parseJSON(jqXHR.responseText);
                    notification("danger", response, "fas fa-times");
                }
            });
            return false;
        })
    </script>
@endpush --}}
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <!-- Meta Tags
        ==============================-->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="keywords" content="" />
    <meta name="copyright" content="" />
    <title>Home - Crafty-workshop</title>
    <!-- Fave Icons
    =============================-->
    <link rel="shortcut icon" href="{{ asset('landing/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('landing/style.css') }}" />
</head>

<body>
    <div class="landing">
        <img src="{{ asset('landing/logo.png')}}" />
        <h3> Watch it + Make it</h3>
        <div class="countdown" data-date="JUN 15, 2022 23:59:59"></div>
    </div>

    <!-- JS & Vendor Files
    =============================-->
    <script src="{{ asset('landing/jquery.js') }}"></script>
    <script src="{{ asset('landing/countdown.js') }}"></script>
    <script>
        $(document).ready(function() {
            "use strict";
            if ($(".countdown").length) {
                $(".countdown").countdown({
                    render: function(data) {
                        if (data.years >= 1) {
                            var $days = data.years * 365 + data.days;
                        } else {
                            var $days = data.days;
                        }
                        $(this.el).html(
                            '<div class="time">' +
                            this.leadingZeros($days) +
                            " <span> Days</span></div>" +
                            '<div class="time">' +
                            this.leadingZeros(data.hours, 2) +
                            " <span >Hours</span></div>" +
                            '<div class="time">' +
                            this.leadingZeros(data.min, 2) +
                            " <span> Minutes</span></div>" +
                            '<div class="time">' +
                            this.leadingZeros(data.sec, 2) +
                            " <span> Seconds</span></div>"
                        );
                    },
                });
            }
        });
    </script>
</body>

</html>
