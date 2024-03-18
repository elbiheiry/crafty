@extends('site.layouts.master')
@section('content')
    <section class="page_head">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>دوراتى التدريبية</h3>
                    <ul>
                        <li>
                            <a href="{{ route('site.index') }}"> الرئيسية </a>
                        </li>
                        <li>دوراتى التدريبية</li>
                    </ul>
                </div>
                <!--End Col-->
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
    <!-- Section ==========================================-->
    <section class="section_color profile">
        <div class="container">
            <div class="row">
                @include('site.pages.profile.templates.sidebar')
                <div class="col-lg-9">
                    <div class="box">
                        <div class="box_title pb-0 pt-0">
                            <ul class="nav nav-tabs">
                                <li>
                                    <a data-toggle="tab" href="#t0" class="active">
                                        دوراتى التدريبية ({{ $courses->count() }})
                                    </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#t1" class="">
                                        الدورات المحفوظة ({{ $user->course_wishlists->count() }})
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="profile_form">
                            <div class="tab-content">
                                <div id="t0" class="tab-pane fade in active show">
                                    <div class="row">
                                        @if ($courses->count() > 0)
                                            @foreach ($courses as $course)
                                                <div class="col-lg-5 col-md-6 col-sm-6" data-aos="fade-up"
                                                    data-aos-delay="80">
                                                    <div class="course">
                                                        <div class="cover">
                                                            <div class="act">
                                                                <button class="icon_link icon icon-bookmark wishlist-btn"
                                                                    data-url="{{ route('site.course.wishlist', ['id' => $course->id]) }}"></button>
                                                            </div>
                                                            <a
                                                                href="{{ route('site.course', ['id' => $course->id, 'slug' => $course->slug]) }}">
                                                                <img
                                                                    src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $course->image,\Carbon\Carbon::now()->addMinutes(120)) }}" />
                                                            </a>
                                                        </div>

                                                        <div class="cont">
                                                            <span class="category">
                                                                {{ $course->category->translate(app()->getLocale())->name }}
                                                            </span>
                                                            <span class="category">
                                                                {{ $course->get_level() }}</span>

                                                            <a href="{{ route('site.course', ['id' => $course->id, 'slug' => $course->slug]) }}"
                                                                class="title">{{ $course->translate(app()->getLocale())->name }}</a>
                                                            <div class="inst">
                                                                <img
                                                                    src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $course->lecturer_image,\Carbon\Carbon::now()->addMinutes(120)) }}" />
                                                                {{ $course->translate(app()->getLocale())->lecturer_name }}
                                                            </div>
                                                        </div>
                                                        <div class="sub_info">
                                                            <span class="num_lesson">
                                                                <i class="icon icon-eye"></i>
                                                                {{ $course->views }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <!--End Course-->
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="alert alert-danger text-center">
                                                لا توجد دورات تدريبيه حاليا
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div id="t1" class="tab-pane fade in">
                                    <div class="row">
                                        @if ($user->course_wishlists->count() > 0)
                                            @foreach ($user->course_wishlists as $course)
                                                <div class="col-lg-5 col-md-6 col-sm-6" data-aos="fade-up"
                                                    data-aos-delay="120">
                                                    <div class="course">
                                                        <div class="cover">
                                                            @if ($course->course->discount != 0 || $course->course->discount)
                                                                <span class="status"> خصم
                                                                    {{ $course->course->discount }} </span>
                                                            @endif

                                                            <div class="act">
                                                                <button class="icon_link icon icon-cross delete-btn"
                                                                    data-url="{{ route('site.course.wishlist.remove', ['id' => $course->id]) }}"></button>
                                                            </div>
                                                            <a
                                                                href="{{ route('site.course', ['id' => $course->course->id, 'slug' => $course->course->slug]) }}">
                                                                {{-- <img
                                                                src="{{ get_image($course->course->image, 'courses') }}" /> --}}
                                                                <img
                                                                    src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $course->course->image,\Carbon\Carbon::now()->addMinutes(120)) }}" />
                                                            </a>
                                                        </div>
                                                        <div class="cont">
                                                            <span class="category">
                                                                {{ $course->course->category->translate(app()->getLocale())->name }}
                                                            </span>
                                                            <span class="category">
                                                                {{ $course->course->get_level() }}</span>

                                                            <a href="{{ route('site.course', ['id' => $course->course->id, 'slug' => $course->course->slug]) }}"
                                                                class="title">{{ $course->course->translate(app()->getLocale())->name }}</a>
                                                            <div class="inst">
                                                                {{-- <img
                                                                src="{{ get_image($course->course->lecturer_image, 'courses') }}" /> --}}
                                                                <img
                                                                    src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $course->course->lecturer_image,\Carbon\Carbon::now()->addMinutes(120)) }}" />
                                                                {{ $course->course->translate(app()->getLocale())->lecturer_name }}
                                                            </div>
                                                        </div>
                                                        <div class="sub_info">
                                                            <button class="link">
                                                                <span>
                                                                    @if ($course->course->price)
                                                                        <i class="icon icon-shopping-cart"></i>
                                                                        {{ $course->course->price_after_discount() }}
                                                                        جنيه
                                                                    @else
                                                                        مجانا
                                                                    @endif
                                                                </span>
                                                            </button>
                                                            <span class="num_lesson">
                                                                <i class="icon icon-eye"></i>
                                                                {{ $course->course->views }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <!--End Course-->
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="alert alert-danger text-center">
                                                لا توجد دورات تدريبيه حاليا
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Col-->
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
    <form method="post" id="delete-form" action="">
        @csrf
        @method('delete')
    </form>
@endsection
@push('js')
    <script>
        $(document).on('click', '.delete-btn', function() {
            var url = $(this).data('url');

            $('#delete-form').attr('action', url).submit();

        });
    </script>
@endpush
