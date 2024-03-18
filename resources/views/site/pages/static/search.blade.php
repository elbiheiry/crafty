@extends('site.layouts.master')
@section('content')
    <!-- Section ==========================================-->
    <section class="page_head">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>نتائج البحث</h3>
                    <ul>
                        <li>
                            <a href="{{ route('site.index') }}"> الرئيسية </a>
                        </li>
                        <li>نتائج البحث</li>
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
    @php
    $x = 80;
    @endphp
    <section class="section_color courses" id="next">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-up" data-aos-delay="40">
                    <div class="section_title">
                        <h3> الدورات التدريبية</h3>
                    </div>
                </div>
                <!--End Col-->
                @foreach ($courses as $course)
                    @if ($course->price != null)
                        <div class="col-lg-4 col-md-6 col-sm-6" data-aos="fade-up" data-aos-delay="{{ $x }}">
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
                    @else
                        <div class="col-lg-4 col-md-6 col-sm-6" data-aos="fade-up" data-aos-delay="{{ $x }}">
                            <div class="course">
                                <div class="cover">
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
                                    <button class="link">
                                        <span>
                                            مــجــانــا
                                        </span>
                                    </button>
                                    <span class="num_lesson">
                                        <i class="icon icon-eye"></i>
                                        {{ $course->views }}
                                    </span>
                                </div>
                            </div>
                            <!--End Course-->
                        </div>
                    @endif
                    @php
                        $x += 40;
                    @endphp
                @endforeach
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
                                        {{-- <img src="{{ get_image($product->image, 'products') }}" /> --}}
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
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
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
