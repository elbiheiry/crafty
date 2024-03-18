@extends('site.layouts.master')
@section('content')
    <!-- Section ==========================================-->
    <section class="page_head">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>الإشتراكات</h3>
                    <ul>
                        <li>
                            <a href="{{ route('site.index') }}"> الرئيسية </a>
                        </li>
                        <li>الإشتراكات</li>
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
                        <div class="box_title">
                            <i class="icon icon-user"></i>
                            الإشتراكات
                        </div>
                        <div class="row profile_form">
                            @if ($user->subscribtion()->where('status', 'Done')->exists())
                                <ul class="w-100 data_view">
                                    <li>
                                        <span>الإشتراك الحالي</span>
                                        <span> {{ $user->subscribtion->package->translate(app()->getLocale())->name }}
                                        </span>
                                    </li>
                                    <li>
                                        <span>قمية الإشتراك</span>
                                        <span> {{ $user->subscribtion->package->translate(app()->getLocale())->price }}
                                        </span>
                                    </li>
                                    <li>
                                        <span> تاريخ الإشتراك </span>
                                        <span>
                                            {{ \Carbon\Carbon::parse($user->subscribtion->start_date)->format('d-M-Y') }}
                                        </span>
                                    </li>

                                    <li>
                                        <span> تاريخ نهاية الإشتراك </span>
                                        <span> {{ \Carbon\Carbon::parse($user->subscribtion->end_date)->format('d-M-Y') }}
                                        </span>
                                    </li>
                                    <li>
                                        <span> حالة الإشتراك </span>
                                        <span> {{ $user->subscribtion->return_status() }} </span>
                                    </li>
                                </ul>
                                <div class="w-100 edit_btns">
                                    <a href="{{ route('site.packages') }}" class="link">
                                        <span> لتجديد الباقه في حاله إنتهائها إضغط هنا </span>
                                    </a>
                                </div>
                            @else
                                <div class="row alert alert-danger text-center">
                                    لم تقم بإتمام أي إشتراكات حتي الان
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
                <!--End Col-->
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
@endsection
