@extends('site.layouts.master')
@push('css')
    {{-- <link href="https://vjs.zencdn.net/7.18.1/video-js.css" rel="stylesheet" /> --}}
@endpush
@push('models')
    <div class="modal fade bd-example-modal-lg" id="common-modal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="video-area">

            </div>
        </div>
    </div>
@endpush
@section('content')
    <!-- Section ==========================================-->
    <section class="page_head">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>{{ $course->translate(app()->getLocale())->name }}</h3>
                    <ul>
                        <li>
                            <a href="{{ route('site.index') }}"> الرئيسية </a>
                        </li>
                        <li>{{ $course->translate(app()->getLocale())->name }}</li>
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
    <section class="section_color course_details">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="intro_video">
                        @if ($course->price)
                            @if ($video_status == 'yes')
                                <div id="player"></div>
                            @else
                                <div class="alert alert-danger text-center">
                                    الفيديو تحت الإنشاء
                                </div>
                            @endif
                        @else
                            <img
                                src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $course->image, \Carbon\Carbon::now()->addMinutes(120)) }}" />
                            <a data-fancybox="gallery" data-type="iframe"
                                data-src="https://www.youtube.com/embed/{{ $course->video_url }}" href="javascript:;"
                                class="video_btn icon icon-video-camera"></a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row invers_md_row">
                <div class="col-lg-8">
                    @if ($course->translate(app()->getLocale())->description)
                        <div class="data_block">
                            <div class="title">عن الدورة</div>
                            <div class="cont">
                                @foreach (explode("\n", $course->translate(app()->getLocale())->description) as $item)
                                    <p>{{ $item }}</p>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!--End Block-->
                    @if ($course->translate(app()->getLocale())->lecturer_name)
                        <div class="data_block">
                            <div class="title">محاضر الدورة</div>
                            <div class="cont">
                                <div class="inst">
                                    <img
                                        src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $course->lecturer_image, \Carbon\Carbon::now()->addMinutes(120)) }}" />
                                    <h3>
                                        {{ $course->translate(app()->getLocale())->lecturer_name }}
                                        <span> {{ $course->translate(app()->getLocale())->lecturer_speciality }} </span>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    @endif
                    <!--End Block-->
                    @if ($course->translate(app()->getLocale())->requirements)
                        <div class="data_block">
                            <div class="title">متطلبات الدورة</div>
                            <div class="cont">
                                <ul class="list">
                                    @foreach (explode("\n", $course->translate(app()->getLocale())->requirements) as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    <!--End Block-->
                    @if ($course->translate(app()->getLocale())->advantages)
                        <div class="data_block">
                            <div class="title">المميزات</div>
                            <div class="cont">
                                <ul class="list">
                                    @foreach (explode("\n", $course->translate(app()->getLocale())->advantages) as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    <!--End Block-->
                    @if ($course->lectures)
                        <div class="data_block">
                            <div class="title">المحتوى</div>
                            <div class="cont">
                                <div class="accordion">
                                    @php
                                        $x = 1;
                                    @endphp
                                    @foreach ($course->lectures as $index => $lecture)
                                        <div class="panel">
                                            <a href="#c{{ $index }}" data-toggle="collapse" class="panel-title"
                                                aria-expanded="true">
                                                {{ $x }}- {{ $lecture->translate(app()->getLocale())->name }}
                                            </a>
                                            <!--End panel-title-->
                                            <div class="panel-collapse collapse show p-0" id="c{{ $index }}">
                                                <ul class="course_list_videos">
                                                    @foreach ($lecture->videos as $video)
                                                        {{-- @php
                                                        $video_link = \Storage::disk('s3.videos')->temporaryUrl('videos/' . $video->link, \Carbon\Carbon::now()->addMinutes(120));
                                                    @endphp --}}
                                                        <li>
                                                            {{ $video->translate(app()->getLocale())->name }}
                                                            @if ($course->price == null)
                                                                <a data-fancybox="gallery" data-type="iframe"
                                                                    data-src="https://www.youtube.com/embed/{{ $course->video_url }}"
                                                                    href="javascript:;">
                                                                    <i class="icon icon-video-camera"></i>
                                                                    عرض الفيديو
                                                                </a>
                                                            @else
                                                                @if (in_array($course->id, $course_ids) ||
                                                                    (auth()->guard('site')->check() &&
                                                                        $status == 'Done'))
                                                                    <a class="btn-modal-view"
                                                                        data-url="{{ route('site.course.video.show', ['id' => $video->id]) }}"
                                                                        href="javascript:;">
                                                                        <i class="icon icon-video-camera"></i>
                                                                        عرض الفيديو
                                                                    </a>
                                                                @endif
                                                            @endif
                                                        </li>
                                                    @endforeach

                                                </ul>
                                            </div>
                                            <!--End Panel Collapse-->
                                        </div>
                                        @php
                                            $x++;
                                        @endphp
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!--End Block-->
                    @if (auth()->guard('site')->check())
                        <div class="data_block">
                            <div class="title">اسأل سؤالك</div>
                            <div class="cont">
                                <form method="post" action="{{ route('site.course.comment', ['id' => $course->id]) }}"
                                    class="comment-form">
                                    @csrf
                                    <div class="form-group">
                                        <label> إختر المحاضرة </label>
                                        <select class="form-control" name="lecture_id">
                                            <option value="0">إختر</option>
                                            @foreach ($course->lectures as $lecture)
                                                <option value="{{ $lecture->id }}">
                                                    {{ $lecture->translate(app()->getLocale())->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label> السؤال </label>
                                        <textarea class="form-control" name="comment"></textarea>
                                    </div>
                                    <button class="link" type="submit"><span> إرسال السؤال </span></button>
                                </form>
                            </div>
                        </div>
                    @endif

                    <!--End Block-->
                </div>
                <div class="col-lg-4">
                    <div class="course_sticky_block">
                        <h3>{{ $course->translate(app()->getLocale())->name }}</h3>
                        @if ($course->price != 0 || $course->price)
                            <h4>{{ $course->price_after_discount() }} جنيه</h4>
                        @endif
                        <ul>
                            <li>
                                <i class="icon icon-bar_chart"></i>
                                المستوى
                                <span> {{ $course->get_level() }} </span>
                            </li>
                            <li>
                                <i class="icon icon-bookmark"></i> التصنيف
                                <span> {{ $course->category->translate(app()->getLocale())->name }} </span>
                            </li>
                            <li>
                                <i class="icon icon-video-camera"></i>
                                عدد الفيدوهات
                                <span> {{ $course->get_videos_counter() }} </span>
                            </li>
                        </ul>
                        <div class="w-100 text-center">
                            <button class="icon_link icon icon-bookmark wishlist-btn"
                                data-url="{{ route('site.course.wishlist', ['id' => $course->id]) }}"></button>

                            @if ($course->price != 0 || $course->price)
                                @if (!in_array($course->id, $course_ids))
                                    <button class="link add-to-cart"
                                        data-url="{{ route('site.course.cart.add', ['id' => $course->id]) }}">
                                        <span>
                                            <i class="icon icon-shopping-cart"></i>
                                            شراء الدورة
                                        </span>
                                @endif
                            @else
                                <button class="link">
                                    <span> مــجــانــا </span>
                            @endif
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
    @if ($products->count() > 0)
        <!-- Section ==========================================-->
        <section class="tools">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-right" data-aos="fade-up" data-aos-delay="40">
                        <div class="section_title">
                            <h3>خامات وأدوات مستخدمة فى الدورة التدريبة</h3>
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
                                                src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $product->product->image, \Carbon\Carbon::now()->addMinutes(120)) }}" />
                                            {{-- <img src="{{ get_image($product->product->image, 'products') }}" /> --}}
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
                        @foreach ($related_courses as $related_course)
                            <div class="item">
                                <div class="course">
                                    <div class="cover">
                                        @if ($related_course->discount != 0 || $related_course->discount)
                                            <span class="status"> خصم {{ $related_course->discount }}
                                            </span>
                                        @endif

                                        <div class="act">
                                            <button class="icon_link icon icon-bookmark wishlist-btn"
                                                data-url="{{ route('site.course.wishlist', ['id' => $related_course->id]) }}"></button>
                                        </div>
                                        <a
                                            href="{{ route('site.course', ['id' => $related_course->id, 'slug' => $related_course->slug]) }}">
                                            <img
                                                src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $related_course->image, \Carbon\Carbon::now()->addMinutes(120)) }}" />

                                        </a>
                                    </div>
                                    <div class="cont">
                                        <span class="category">
                                            {{ $related_course->category->translate(app()->getLocale())->name }}
                                        </span>
                                        <span class="category"> {{ $related_course->get_level() }}</span>

                                        <a href="{{ route('site.course', ['id' => $related_course->id, 'slug' => $related_course->slug]) }}"
                                            class="title">{{ $related_course->translate(app()->getLocale())->name }}</a>
                                        <div class="inst">
                                            <img
                                                src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $related_course->lecturer_image, \Carbon\Carbon::now()->addMinutes(120)) }}" />
                                            {{ $related_course->translate(app()->getLocale())->lecturer_name }}
                                        </div>
                                    </div>
                                    <div class="sub_info">

                                        @if ($related_course->price)
                                            @if (!in_array($related_course->id, $course_ids))
                                                <button class="link add-to-cart"
                                                    data-url="{{ route('site.course.cart.add', ['id' => $course->id]) }}">
                                                    <span>
                                                        <i class="icon icon-shopping-cart"></i>
                                                        {{ $related_course->price_after_discount() }} جنيه
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
                                            {{ $related_course->views }}
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
@endsection
@push('js')
    <script>
        $(document).on('submit', '.comment-form', function() {
            var form = $(this);
            var url = form.attr('action');
            var formData = new FormData(form[0]);
            form.find(":submit").attr('disabled', true).html('<span> إنتظر </span>');

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
                    form.find(":submit").attr('disabled', false).html('<span> إرسال السؤال </span>');
                }
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                }
            });
            return false;
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
    </script>
    {{-- <script src="https://vjs.zencdn.net/7.18.1/video.min.js"></script>
    <script src="{{ asset('site/js/videojs-contrib-hls.js') }}"></script>
    <script>
        var player = videojs('my-video');
    </script> --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/clappr@latest/dist/clappr.min.js"></script>
    <script type="text/javascript"
        src="//cdn.jsdelivr.net/gh/clappr/clappr-level-selector-plugin@latest/dist/level-selector.min.js"></script>
    <script>
        var player = new Clappr.Player({
            source: "{{ $course->video_url }}",
            autoPlay: true,
            height: 500,
            width: '100%',
            parentId: "#player",
            plugins: [LevelSelector],
            levelSelectorConfig: {
                title: 'Quality',
                labels: {
                    4: '',
                    3: '',
                    1: '', // 240kbps
                    2: '', // 500kbps
                    0: '', // 120kbps
                },
                labelCallback: function(playbackLevel, customLabel) {
                    return customLabel + playbackLevel.level.height + 'p'; // High 720p
                }
            },
        });
        //open edit form in model
        $(document).on('click', '.btn-modal-view', function() {
            var $this = $(this);
            var url = $this.data('url');
            var originalHtml = $this.html();

            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    $this.prop('disabled', false).html(originalHtml);
                    $('#common-modal').modal('show');
                    $('#video-area').html(data);
                }
            });
        });
    </script>
@endpush
