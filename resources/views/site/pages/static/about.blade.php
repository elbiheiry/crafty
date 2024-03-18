@extends('site.layouts.master')
@section('content')
    <!-- Section ==========================================-->
    <section class="page_head">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>عـن كـرافـتـى</h3>
                    <ul>
                        <li>
                            <a href="{{ route('site.index') }}"> الرئيسية </a>
                        </li>
                        <li>عـن كـرافـتـى</li>
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
    <section class="video_wrap">
        <div class="container">
            <div class="row">
                <video autoplay loop width="100%" height="520" muted>
                    <source src="{{ asset('site/images/video.mp4') }}" />
                </video>
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
    <!--End Section-->
    <!-- Section ==========================================-->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about_cont">
                        <h3>{{ $about->translate(app()->getLocale())->title }}</h3>
                        {!! $about->translate(app()->getLocale())->description !!}
                    </div>
                </div>
                <!--End col-->
                <div class="col-lg-6">
                    <div class="about_img">
                        {{-- <img src="{{ get_image($about->image, 'about') }}" class="w-100" /> --}}
                        <img src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $about->image, \Carbon\Carbon::now()->addMinutes(120)) }}"
                            class="w-100" />
                    </div>
                </div>
                @foreach ($features as $feature)
                    <div class="col-lg-3 col-sm-6">
                        <div class="feature_item">
                            {{-- <img src="{{ get_image($feature->image, 'features') }}" /> --}}
                            <img src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $feature->image,\Carbon\Carbon::now()->addMinutes(120)) }}"
                                class="w-100" />
                            {{ $feature->translate(app()->getLocale())->title }}
                        </div>
                    </div>
                @endforeach
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
    <!--End Section-->

    <!-- Section ==========================================-->
    <section class="static section_color">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 text-center" data-aos="fade-up" data-aos-delay="40">
                    <div class="section_title">
                        <h3>فريق العمل</h3>
                        <p>
                            الوصول إلى أفضل الخبراء في العالم الذين يسهلون تعلم جديد
                            المهارات
                        </p>
                    </div>
                </div>
                <!--End Col-->
                <div class="col-12" data-aos="fade-up" data-aos-delay="80">
                    <div class="owl-carousel owl-theme team_slider">
                        @foreach ($members as $member)
                            <div class="item">
                                <div class="team_item">
                                    {{-- <img src="{{ get_image($member->image, 'team') }}" /> --}}
                                    <img
                                        src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $member->image,\Carbon\Carbon::now()->addMinutes(120)) }}" />
                                    <h3>{{ $member->translate(app()->getLocale())->name }}</h3>
                                    <p>{{ $member->translate(app()->getLocale())->position }}</p>
                                </div>
                                <!--End Serv Item-->
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
    <!-- Section ==========================================-->
    <section class="static">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 text-center" data-aos="fade-up" data-aos-delay="40">
                    <div class="section_title">
                        <h3>المستثمرين</h3>
                        <p>
                            الوصول إلى أفضل الخبراء في العالم الذين يسهلون تعلم جديد
                            المهارات
                        </p>
                    </div>
                </div>
                <!--End Col-->
                <div class="col-12" data-aos="fade-up" data-aos-delay="80">
                    <div class="owl-carousel owl-theme partners_slider">
                        @foreach ($investors as $investor)
                            <div class="item">
                                <div class="partner_item">
                                    {{-- <img src="{{ get_image($investor->image, 'investors') }}" /> --}}
                                    <img
                                        src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $investor->image,\Carbon\Carbon::now()->addMinutes(120)) }}" />
                                </div>
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

    <!-- Section ==========================================-->
    <section class="blog section_color">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-up" data-aos-delay="40">
                    <div class="section_title">
                        <h3>
                            آخر الأخبار
                        </h3>
                    </div>
                </div>
                <!--End Col-->
                <div class="owl-carousel owl-theme news_slider">
                    @foreach ($articles as $article)
                        <div class="item">
                            <a href="{{ route('site.article', ['id' => $article->id, 'slug' => $article->slug]) }}"
                                class="blog_item">
                                <div class="cover">
                                    {{-- <img src="{{ get_image($article->outer_image, 'articles') }}" /> --}}
                                    <img
                                        src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $article->outer_image,\Carbon\Carbon::now()->addMinutes(120)) }}" />
                                </div>
                                <div class="cont">
                                    <span class="date">
                                        <i class="icon icon-calendar"></i>
                                        {{ $article->created_at->format('d - m - Y') }}
                                    </span>
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
                </div>
            </div>
            <!--End Row-->
        </div>
        @include('site.layouts.subscribe')
    </section>
    <!--End Section-->
@endsection
