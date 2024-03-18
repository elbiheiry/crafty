@extends('site.layouts.master')
@section('content')
    <!-- Section ==========================================-->
    <section class="page_head">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>الطلبات السابقه</h3>
                    <ul>
                        <li>
                            <a href="{{ route('site.index') }}"> الرئيسية </a>
                        </li>
                        <li>الطلبات السابقه</li>
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
                            {{-- <i class="icon icon-user"></i> --}}
                            الطلبات السابقه
                        </div>
                        <form class="profile_form">
                            <div class="tab-content">
                                <div id="t0" class="tab-pane fade in active show">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>رقم الطلب</th>
                                                <th>تاريخ الطلب</th>
                                                <th>قيمة الطلب</th>
                                                <th>الحالة</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $x = 1;
                                            @endphp
                                            @foreach ($user->orders()->where('user_subscribtion_id', null)->where('payment_details', '!=', null)->get()
        as $order)
                                                @php
                                                    $payment = json_decode($order->payment_details);
                                                @endphp
                                                {{-- {{ $payment }} --}}
                                                <tr>
                                                    <td>{{ $x }}</td>
                                                    <td><a
                                                            href="{{ route('site.profile.bill', ['id' => $order->id]) }}">#{{ $order->id }}</a>
                                                    </td>
                                                    <td>{{ $order->created_at->format('d / m / Y') }}</td>
                                                    <td>{{ isset($payment)? (isset($payment->payload)? $payment->payload['amount'] / 100: $payment->amount_cents / 100): '' }}
                                                        جنيه</td>
                                                    <td>
                                                        @if ($order->status == 'pending')
                                                            <span class="status red_bc"> لم يتم إستكمال الدفع </span>
                                                        @else
                                                            <span class="status green_bc"> تم التنفيذ </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @php
                                                    $x++;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <!--End Col-->
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
@endsection
