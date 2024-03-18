@extends('site.layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('public/site/vendor/swiper.css') }}" />
@endpush
@section('content')
    <!-- Section ==========================================-->
    <section class="page_head">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>خامات وأدوات</h3>
                    <ul>
                        <li>
                            <a href="{{ route('site.index') }}"> الرئيسية </a>
                        </li>
                        <li>خامات وأدوات</li>
                    </ul>
                </div>
                <!--End Col-->
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
    <!--End Section-->
    <!-- Start Section ============================= -->
    <section class="product section_color">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product_slider">
                        <div class="swiper mySwiper2">
                            <div class="swiper-wrapper">
                                @foreach ($product->images as $image)
                                    <a href="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $image->image, \Carbon\Carbon::now()->addMinutes(120)) }}"
                                        class="swiper-slide" data-fancybox="gallery">
                                        <img
                                            src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $image->image, \Carbon\Carbon::now()->addMinutes(120)) }}" />
                                    </a>
                                @endforeach
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                        <div thumbsSlider="" class="swiper mySwiper">
                            <div class="swiper-wrapper">
                                @foreach ($product->images as $image)
                                    <div class="swiper-slide">
                                        <img
                                            src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $image->image, \Carbon\Carbon::now()->addMinutes(120)) }}" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product_details">
                        <a href="{{ route('site.products', ['id' => $product->category->id, 'slug' => $product->category->name]) }}"
                            class="link categ_link">
                            <span>
                                <i class="fa fa-tag"></i>
                                قسم {{ $product->category->translate(app()->getLocale())->name }}
                            </span>
                        </a>
                        <h2>{{ $product->translate(app()->getLocale())->name }}</h2>

                        <h3>{{ $product->price }} جـنـيـه</h3>
                        {!! $product->translate(app()->getLocale())->description !!}

                        <form class="w-100 add-to-cart-form" method="post"
                            action="{{ route('site.product.cart.add', ['id' => $product->id]) }}">
                            @csrf
                            @method('post')
                            <div class="cat-number">
                                <a href="#" class="number-down">
                                    <i class="icon icon-minus"></i>
                                </a>
                                <input min="1" value="1" max="{{ $product->quantity }}" class="form-control"
                                    type="number" name="quantity" />
                                <a href="#" class="number-up">
                                    <i class="icon icon-add"></i>
                                </a>
                            </div>
                            <button class="link" type="submit">
                                <span>
                                    <i class="icon icon-shopping-cart"></i> إضافة للعربة
                                </span>
                            </button>
                            <button class="icon_link icon icon-bookmark wishlist-btn"
                                data-url="{{ route('site.product.wishlist', ['id' => $product->id]) }}"></button>
                        </form>
                    </div>
                    <div class="product_details">
                        <div class="w-100 mt-0">
                            <span> مشاركة المنتج عبر </span>
                            <script async src="https://static.addtoany.com/menu/page.js"></script>
                            <ul class="social a2a_kit">
                                <li>
                                    <a class="icon_link icon icon-facebook a2a_button_facebook">
                                    </a>
                                </li>
                                <li>
                                    <a class="icon_link icon icon-linkedin a2a_button_linkedin">
                                    </a>
                                </li>
                                <li>
                                    <a class="icon_link icon icon-instagram a2a_button_instagram">
                                    </a>
                                </li>
                                <li>
                                    <a class="icon_link icon icon-google a2a_button_google_gmail">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
    <!--End Section-->
    @if ($related_products->count() > 0)
        <!-- Section ==========================================-->
        <section class="tools">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-right">
                        <div class="section_title">
                            <h3>منتجات متعلقة</h3>
                        </div>
                    </div>
                    <!--End Col-->
                    <div class="col-12" data-aos="fade-up" data-aos-delay="80">
                        <div class="owl-carousel owl-theme tools_slider">
                            @foreach ($related_products as $related_product)
                                <div class="item">
                                    <div class="tool_item">
                                        <a href="{{ route('site.product', ['id' => $related_product->id, 'slug' => $related_product->slug]) }}"
                                            class="cover">
                                            <img
                                                src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $related_product->image,\Carbon\Carbon::now()->addMinutes(120)) }}" />
                                        </a>
                                        <div class="cont">
                                            <a
                                                href="{{ route('site.product', ['id' => $related_product->id, 'slug' => $related_product->slug]) }}">
                                                {{ $related_product->translate(app()->getLocale())->name }}</a>
                                            <p>{{ $related_product->price }} جنيه</p>
                                            <div class="w-100">
                                                <button class="icon_link icon icon-bookmark wishlist-btn"
                                                    data-url="{{ route('site.product.wishlist', ['id' => $product->id]) }}"></button>
                                                <button class="link">
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
                </div>
                <!--End Row-->
            </div>
            <!--End Container-->
        </section>
        <!--End Section-->
    @endif
    @if ($courses->count() > 0)
        <!-- Section ==========================================-->
        <section class="section_color courses">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-right" data-aos="fade-up" data-aos-delay="40">
                        <div class="section_title">
                            <h3>دورات تدريبية متعلقة</h3>
                        </div>
                    </div>
                    <!--End Col-->

                    <div class="col-12" data-aos="fade-up" data-aos-delay="80">
                        <div class="owl-carousel owl-theme related_courses_slider">
                            @foreach ($courses as $course)
                                <div class="item">
                                    <div class="course">
                                        <div class="cover">
                                            @if ($course->course->discount != 0 || $course->course->discount)
                                                <span class="status"> خصم {{ $course->course->discount }} </span>
                                            @endif

                                            <div class="act">
                                                <button class="icon_link icon icon-bookmark"></button>
                                            </div>
                                            <a
                                                href="{{ route('site.course', ['id' => $course->course->id, 'slug' => $course->course->slug]) }}">
                                                <img
                                                    src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $course->course->image,\Carbon\Carbon::now()->addMinutes(120)) }}" />
                                            </a>
                                        </div>
                                        <div class="cont">
                                            <span class="category">
                                                {{ $course->course->category->translate(app()->getLocale())->name }}
                                            </span>
                                            <span class="category"> {{ $course->course->get_level() }}</span>

                                            <a href="{{ route('site.course', ['id' => $course->course->id, 'slug' => $course->course->slug]) }}"
                                                class="title">{{ $course->course->translate(app()->getLocale())->name }}</a>
                                            <div class="inst">
                                                <img
                                                    src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $course->course->lecturer_image,\Carbon\Carbon::now()->addMinutes(120)) }}" />
                                                {{ $course->course->translate(app()->getLocale())->lecturer_name }}
                                            </div>
                                        </div>
                                        <div class="sub_info">
                                            @if ($course->course->price)
                                                @if (!in_array($course->course->id, $course_ids))
                                                    <button class="link add-to-cart"
                                                        data-url="{{ route('site.course.cart.add', ['id' => $course->course->id]) }}">
                                                        <span>
                                                            <i class="icon icon-shopping-cart"></i>
                                                            {{ $course->course->price_after_discount() }} جنيه
                                                        </span>
                                                    </button>
                                                @else
                                                    <button class="link">
                                                        <span>
                                                            مجانا
                                                        </span>
                                                    </button>
                                                @endif
                                            @endif
                                            <span class="num_lesson">
                                                <i class="icon icon-eye"></i>
                                                {{ $course->course->views }}
                                            </span>
                                        </div>
                                    </div>
                                    <!--End Course-->
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!--End Row-->
            </div>
            <!--End Container-->
        </section>
        <!--End Section-->
    @endif
@endsection
@push('js')
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            loop: false,
            spaceBetween: 10,
            slidesPerView: 5,
            freeMode: true,
            watchSlidesProgress: true,
        });
        var swiper2 = new Swiper(".mySwiper2", {
            loop: false,
            autoplay: true,
            spaceBetween: 0,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: swiper,
            },
        });

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
        $(".add-to-cart-form").on('submit', function(e) {

            var url = $(this).attr('action');

            $.ajax({
                url: url,
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    notification("success", response.message, "fas fa-check");
                    $('#cart-count').html(response.counter)
                },
                error: function(jqXHR) {
                    var response = $.parseJSON(jqXHR.responseText);
                    notification("danger", response, "fas fa-times");
                }
            });

            return false;
        });
    </script>
@endpush
