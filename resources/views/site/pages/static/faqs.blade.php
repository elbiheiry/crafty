@extends('site.layouts.master')
@section('content')
    <!-- Section ==========================================-->
    <section class="page_head">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>الأسئلة الشائعة</h3>
                    <ul>
                        <li>
                            <a href="{{ route('site.index') }}"> الرئيسية </a>
                        </li>
                        <li>الأسئلة الشائعة</li>
                    </ul>
                </div>
                <!--End Col-->
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
    <!--End Section-->
    <!-- Section  ==========================================-->
    <section class="static faqs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_title">
                        <h3>أسئلتنا الشائعة قد تساعدك على فهم المزيد عن خدماتنا</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7">
                    @foreach ($categories as $category)
                        <div class="data_block">
                            <div class="title">{{ $category->translate(app()->getLocale())->name }}</div>
                            <div class="cont">
                                <div class="inst">
                                    <div class="accordion" id="faqs">
                                        @foreach ($category->faqs()->orderBy('order', 'asc')->get()
        as $index => $faq)
                                            <div class="panel">
                                                <a href="#q{{ $index }}" data-toggle="collapse"
                                                    class="panel-title {{ $index != 0 ? 'collapsed' : '' }}"
                                                    aria-expanded="true">
                                                    {{ $faq->translate(app()->getLocale())->question }}
                                                </a>
                                                <!--End panel-title-->
                                                <div class="panel-collapse collapse {{ $index == 0 ? 'show' : '' }} faqs_panel"
                                                    id="q{{ $index }}" data-parent="#faqs">
                                                    {{ $faq->translate(app()->getLocale())->answer }}
                                                </div>
                                                <!--End Panel Collapse-->
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="col-lg-5 text-center">
                    <img src="{{ asset('site/images/faqs.png') }}" class="static_img mt-0 faq_img" />
                </div>
                <!--End Col-->
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
    <!--End Section-->
@endsection
