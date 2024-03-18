@extends('site.layouts.master')
@section('content')
    <div class="modal fade bd-example-modal-lg" id="iframe-modal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="col-lg-12" id="iframe-div"></div>
            </div>
        </div>
    </div>
    <!-- Section  ==========================================-->
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
    <!--End Section-->
    <!-- Section  ==========================================-->
    <section class="section_color cart">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="block-item">
                        <div class="form-title">
                            تفاصيل الطلب

                            <a href="{{ route('site.cart') }}"> تعديل الطلب </a>
                        </div>
                        <div class="cart-total">
                            <ul>
                                @foreach ($items as $item)
                                    @if ($item->associatedModel == 'course')
                                        <li>
                                            <a
                                                href="{{ route('site.course', ['id' => $item->attributes['id'], 'slug' => $item->attributes['slug']]) }}">
                                                {{-- <img src="{{ get_image($item->attributes['image'], 'courses') }}" /> --}}
                                                <img
                                                    src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $item->attributes['image'],\Carbon\Carbon::now()->addMinutes(120)) }}" />
                                                {{ $item->name }}
                                            </a>
                                            <span> {{ $item->getPriceSum() }} جنيه </span>
                                        </li>
                                    @else
                                        <li>
                                            <div class="cont">
                                                {{-- <img src="{{ get_image($item->attributes['image'], 'products') }}" /> --}}
                                                <img
                                                    src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $item->attributes['image'],\Carbon\Carbon::now()->addMinutes(120)) }}" />
                                                <a
                                                    href="{{ route('site.product', ['id' => $item->attributes['id'], 'slug' => $item->attributes['slug']]) }}">
                                                    {{ $item->name }}
                                                    <div class="w-100">X{{ $item->quantity }}</div>
                                                </a>
                                            </div>
                                            <span> {{ $item->getPriceSum() }} جنيه </span>
                                        </li>
                                    @endif
                                @endforeach

                                <li>
                                    الإجـمـالـي :
                                    <span> {{ \Cart::getTotal() }} جنيه </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="block-item">
                        <div class="form-title white">
                            <i class="icon icon-cc-visa"></i>
                            إختر طريقة الدفع
                        </div>
                        <form class="cart-total" method="post" action="{{ route('site.checkout.paymob') }}">
                            @csrf
                            @method('post')
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <input type="radio" id="payment1" name="payment" value="paymob"
                                            class="payment-input">
                                        <label for="payment1"> <img src="{{ asset('site/images/paymob.png') }}"
                                                width="100px"></label><br>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <input type="radio" id="payment2" name="payment" value="opay"
                                            class="payment-input">
                                        <label for="payment2"> <img src="{{ asset('site/images/opay.png') }}"
                                                width="100px"></label><br>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <button class="link" type="submit">
                                        <i class="icon icon-shopping-cart"></i>
                                        شراء الآن
                                    </button>
                                </div>
                            </div>
                        </form>

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
        $(document).on('submit', '.cart-total', function() {
            if (!$('.payment-input').is(':checked')) {
                notification("danger", "يجب ان تقوم بإختيار طريقة للدفع", "fas fa-times");
            } else {
                var form = $(this);
                var url = $('input[name="payment"]:checked').val() == 'opay' ?
                    "{{ route('site.checkout.opay') }}" :
                    "{{ route('site.checkout.paymob') }}";
                var formData = new FormData(form[0]);
                form.find(":submit").attr('disabled', true).html('<i class="icon icon-shopping-cart"></i> إنتظر');

                $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: 'json',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {

                        if ($('input[name="payment"]:checked').val() == 'opay') {
                            window.location.href = response;
                        } else {
                            $('#iframe-div').html(
                                '<iframe src="https://accept.paymob.com/api/acceptance/iframes/338817?payment_token=' +
                                response +
                                '" width="100%" style="position:fixed;top:0;left:0;z-index:9999" height="100%"></iframe>'
                            );
                            $('#iframe-modal').modal('show');
                        }
                    },
                    error: function(jqXHR) {
                        var response = $.parseJSON(jqXHR.responseText);

                        notification("danger", response, "fas fa-times");
                        form.find(":submit").attr('disabled', false).html(
                            '<i class="icon icon-shopping-cart"></i> شراء الآن');
                    }
                });
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('input[name="_token"]').val()
                    }
                });
            }

            return false;
        });
    </script>
@endpush
