@extends('site.layouts.master')
@section('content')
    <!-- Section ==========================================-->
    <section class="page_head">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>الملف الشخصى</h3>
                    <ul>
                        <li>
                            <a href="{{ route('site.index') }}"> الرئيسية </a>
                        </li>
                        <li>الملف الشخصى</li>
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
                            الملف الشخصى
                        </div>
                        <div class="row profile_form">
                            <ul class="w-100 data_view">
                                <li>
                                    <span>الاسم بالكامل</span>
                                    <span> {{ $user->name }} </span>
                                </li>
                                <li>
                                    <span>البريد الالكترونى</span>
                                    <span> {{ $user->email }} </span>
                                </li>
                                <li>
                                    <span> رقم الهاتف </span>
                                    <span> {{ $user->phone }} </span>
                                </li>

                                <li>
                                    <span> العنوان </span>
                                    <span>
                                        {{ $user->address }} , {{ $user->city }} , {{ $user->country }}
                                    </span>
                                </li>
                                <li>
                                    <span> العمر </span>
                                    <span> {{ $user->age }} </span>
                                </li>
                                <li>
                                    <span> لينك الفيسبوك </span>
                                    <span>{{ $user->facebook }}</span>
                                </li>
                                <li>
                                    <span> لينك إنستجرام</span>
                                    <span>{{ $user->instagram }}</span>
                                </li>
                            </ul>
                            <div class="w-100 edit_btns">
                                <a href="{{ route('site.profile.update') }}" class="link">
                                    <span> تعديل البيانات </span>
                                </a>
                                <a href="{{ route('site.profile.update_password') }}" class="link">
                                    <span> تغير كلمة المرور </span>
                                </a>
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
@endsection
