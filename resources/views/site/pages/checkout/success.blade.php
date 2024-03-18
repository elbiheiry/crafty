@extends('site.layouts.master')
@push('css')
    <style>
        .thanks {
            text-align: center;
            display: flex;
            /* justify-content: space-between; */
            align-items: center;
            flex-direction: column;
            /* height: 100vh; */
            background-color: var(--main_color);
            padding: 27px;
            overflow: hidden;
        }

        .thanks i {
            display: block;
            font-size: 60px;
            color: var(--main_color);
            margin-bottom: 25px;
            background-color: #fff;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            line-height: 100px;
            margin: auto auto 15px;
        }

        .thanks h2 {
            text-transform: uppercase;
            font-weight: 600;
            font-size: 22px;
            line-height: 44px;
        }

        .thanks p {
            font-size: 16px;
            color: #f1f1f1;
        }

        .thanks img {
            width: 100px;
        }

    </style>
@endpush
@section('content')
    <!-- Section ==========================================-->
    <section class="page_head">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>عربة الشراء</h3>
                    <ul>
                        <li>
                            <a href="{{ route('site.index') }}"> الرئيسية </a>
                        </li>
                        <li>عربة الشراء</li>
                    </ul>
                </div>
                <!--End Col-->
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
    <section class="section_color cart">
        <div class="container">
            <div class="row  justify-content-center">
                <div class="thanks">
                    <img src="{{ asset('site/images/logo.png') }}" />
                    <h2>
                        <i class="far fa-thumbs-up"></i>
                        تمت عمليه الشراء بنجاح وسيتم تحويلكم خلال ثواني
                    </h2>
                </div>
            </div>
        </div>
    </section>
@endsection
