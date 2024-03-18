@extends('site.layouts.master')
@section('content')
    <!-- Section ==========================================-->
    <section class="page_head">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>الأخــبــار</h3>
                    <ul>
                        <li>
                            <a href="{{ route('site.index') }}"> الرئيسية </a>
                        </li>
                        <li>الأخــبــار</li>
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
    <section class="blog section_color">
        <div class="container">
            <div class="row">
                <div class="col-lg-8" data-aos="fade-up" data-aos-delay="40">
                    <div class="news_details">
                        <h2>{{ $article->translate(app()->getLocale())->title }}</h2>

                        {{-- <img src="{{ get_image($article->inner_image, 'articles') }}" /> --}}
                        <img
                            src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $article->inner_image,\Carbon\Carbon::now()->addMinutes(120)) }}" />
                        {!! $article->translate(app()->getLocale())->description !!}
                    </div>
                </div>
                <!--End Col-->
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="40">
                    <script async src="https://static.addtoany.com/menu/page.js"></script>
                    <div class="side_block">
                        <div class="side_txt">
                            <i class="icon icon-share"></i>
                            مشاركة الخبر
                        </div>

                        <ul class="social a2a_kit">
                            <li>
                                <a class="icon_link icon icon-facebook a2a_button_facebook"></a>
                            </li>
                            <li>
                                <a class="icon_link icon icon-instagram a2a_button_instagram"></a>
                            </li>
                            <li>
                                <a class="icon_link icon icon-linkedin a2a_button_linkedin"></a>
                            </li>
                            <li>
                                <a class="icon_link icon icon-google a2a_button_google_gmail"></a>
                            </li>
                        </ul>
                    </div>
                    <div class="side_block sticky">
                        <div class="side_txt">
                            <i class="icon icon-files"></i>

                            أخبار متعلقة
                        </div>
                        @foreach ($related_articles as $related_article)
                            <a href="{{ route('site.article', ['id' => $related_article->id, 'slug' => $related_article->slug]) }}"
                                class="blog_item listed">
                                <div class="cover">
                                    {{-- <img src="{{ get_image($related_article->outer_image, 'articles') }}" /> --}}
                                    <img
                                        src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $related_article->outer_image,\Carbon\Carbon::now()->addMinutes(120)) }}" />
                                </div>
                                <div class="cont">
                                    <h3>
                                        {{ $related_article->translate(app()->getLocale())->title }}
                                    </h3>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <!--End Item-->

                </div>
            </div>
            <!--End Col-->
        </div>
        <!--End Row-->
    </section>
    <!--End Section-->
    <!-- Section ==========================================-->
    @if ($products->count() > 0)
        <section class="tools">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-right" data-aos="fade-up" data-aos-delay="40">
                        <div class="section_title">
                            <h3>خامات وأدوات متعلقة </h3>
                        </div>
                    </div>
                    <!--End Col-->
                    <div class="col-12" data-aos="fade-up" data-aos-delay="80">
                        <div class="owl-carousel owl-theme tools_slider">
                            @foreach ($products as $product)
                                <div class="item">
                                    <div class="tool_item">
                                        <div class="cover">
                                            <img
                                                src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $product->product->image,\Carbon\Carbon::now()->addMinutes(120)) }}" />
                                            <div class="cover_btns">
                                                <a href="{{ route('site.product', ['id' => $product->product->id, 'slug' => $product->product->slug]) }}"
                                                    class="icon_link icon icon-eye"></a>
                                            </div>
                                        </div>
                                        <div class="cont">
                                            <a
                                                href="{{ route('site.product', ['id' => $product->product->id, 'slug' => $product->product->slug]) }}">{{ $product->product->translate(app()->getLocale())->name }}</a>
                                            <p>{{ $product->product->price }} جنيه</p>
                                            <div class="w-100">
                                                <button class="icon_link icon icon-bookmark wishlist-btn"
                                                    data-url="{{ route('site.product.wishlist', ['id' => $product->product->id]) }}"></button>
                                                <button class="link add-to-cart"
                                                    data-url="{{ route('site.product.cart.add', ['id' => $product->product->id]) }}">
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
    @endif
    @if ($courses->count() > 0)
        <!-- Section ==========================================-->
        <section class="section_color courses">
            <div class="container">
                <div class="row">
                    <div class="col-12" data-aos="fade-up" data-aos-delay="40">
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
                                                <button class="icon_link icon icon-bookmark wishlist-btn"
                                                    data-url="{{ route('site.course.wishlist', ['id' => $course->course->id]) }}"></button>
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

    @include('site.layouts.subscribe')
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
@endpush
