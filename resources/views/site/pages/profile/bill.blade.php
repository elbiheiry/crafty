@extends('site.layouts.master')
@section('content')
    <section class="page_head">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>الفاتورة</h3>
                    <ul>
                        <li>
                            <a href="{{ route('site.index') }}"> الرئيسية </a>
                        </li>
                        <li>الفاتورة</li>
                    </ul>
                </div>
                <!--End Col-->
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
    <section class="profile">
        <div class="container">
            <div class="row text-center">
                <div class="col-12 bill_wrap">
                    <div class="bill">
                        <img src="{{ asset('site/images/logo.png') }}" class="logo" />
                        <div class="qr">
                            <ul class="info">
                                <li><span> رقم االفاتورة </span> {{ $order->id }}</li>
                                <li><span> تاريخ الطلب </span> {{ $order->created_at->format('d/M/Y') }}</li>
                                <li><span>إسم العميل</span> {{ $order->user->name }}</li>
                                <li><span>رقم الهاتف</span> {{ $order->user->phone }}</li>
                            </ul>
                            {!! QrCode::size(120)->generate($codeContents) !!}
                        </div>
                        <div class="items">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>إسم الصنف</th>
                                        <th>السعر</th>
                                        <th>الكمية</th>
                                        <th>إجمالى السعر</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (json_decode($order->order_details) as $detail)
                                        @if ($detail->associatedModel == 'product')
                                            @php
                                                $product = \App\Models\Product::findOrFail($detail->attributes->id);
                                            @endphp
                                            <tr>
                                                <th>{{ $product->translate(app()->getLocale())->name }}</th>
                                                <th>{{ $detail->price }}</th>
                                                <th>{{ $detail->quantity }}</th>
                                                <th>{{ $detail->price * $detail->quantity }}</th>
                                            </tr>
                                        @else
                                            @php
                                                $course = \App\Models\Course::findOrFail($detail->attributes->id);
                                            @endphp
                                            <tr>
                                                <th>{{ $course->translate(app()->getLocale())->name }}</th>
                                                <th>{{ $detail->price }}</th>
                                                <th>{{ $detail->quantity }}</th>
                                                <th>{{ $detail->price * $detail->quantity }}</th>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <ul class="bill_total">
                            @php
                                $payment = json_decode($order->payment_details);
                            @endphp
                            <li>تكلفة الطلب <span>
                                    {{ isset($payment) ? (isset($payment->payload) ? $payment->payload['amount'] / 100 : $payment->amount_cents / 100) : '' }}
                                    جنيه </span></li>
                            <li>القيمة المضافة <span> جنيه </span></li>
                            {{-- <li>قيمة الخصم <span> {{20}} جنيه </span></li> --}}
                            <li>إجمالى الطلب <span> @php
                                $payment = json_decode($order->payment_details);
                            @endphp جنيه</span></li>
                        </ul>
                        <div class="payment">
                            <h3>بيانات الدفع</h3>
                            <ul>
                                <li>
                                    <span> تاريخ الدفع </span>
                                    {{ $order->created_at->format('d/M/Y') }}
                                </li>
                                <li>
                                    <span> طريقة الدفع </span>
                                    {{ isset($payment->payload) ? 'Opay' : 'Paymob' }}
                                </li>
                                <li>
                                    <span> الرقم المسلسل </span>
                                    2660587942
                                </li>
                            </ul>
                        </div>
                        <div class="owner">
                            <a href="{{ route('site.index') }}">
                                <span> إسم الموقع : </span>

                                موقع كرافتى</a>
                            <p>
                                <span> الرقم الضريبى </span>
                                45258741369
                            </p>
                            <p>
                                <span> رقم الهاتف </span>

                                01557831370
                            </p>
                        </div>
                    </div>
                    <button class="link green_bc print_btn" onclick="window.print();">
                        <span> طباعة الفاتورة </span>
                    </button>
                </div>
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
@endsection
