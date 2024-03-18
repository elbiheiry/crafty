@extends('site.layouts.master')
@section('content')
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
    <!-- Section ==========================================-->
    <section class="section_color cart">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    @foreach ($items as $item)
                        @if ($item->associatedModel == 'course')
                            <div class="course">
                                <a href="{{ route('site.course', ['id' => $item->attributes['id'], 'slug' => $item->attributes['slug']]) }}"
                                    class="cover">
                                    {{-- <img src="{{ get_image($item->attributes['image'], 'courses') }}" /> --}}
                                    <img
                                        src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $item->attributes['image'],\Carbon\Carbon::now()->addMinutes(120)) }}" />
                                </a>
                                <div class="cont">
                                    <span class="category"> {{ $item->attributes['category_name'] }} </span>
                                    <span class="category"> {{ $item->attributes['level'] }}</span>

                                    <a href="{{ route('site.course', ['id' => $item->attributes['id'], 'slug' => $item->attributes['slug']]) }}"
                                        class="title">{{ $item->name }}</a>
                                    <div class="inst">
                                        <img
                                            src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $item->attributes['lecturer_image'],\Carbon\Carbon::now()->addMinutes(120)) }}" />
                                        {{-- <img src="{{ get_image($item->attributes['lecturer_image'], 'courses') }}" /> --}}
                                        {{ $item->attributes['lecturer_name'] }}
                                    </div>
                                    <div class="sub_info w-100">

                                        <span class="price"> {{ $item->getPriceSum() }} جنيه </span>
                                        <span class="num_lesson">
                                            <i class="icon icon-eye"></i>
                                            {{ $item->attributes['views'] }} فيديو
                                        </span>
                                    </div>
                                </div>

                                <button class="icon_link icon icon-cross remove_btn"
                                    data-url="{{ route('site.cart.delete', ['id' => $item->id]) }}"></button>
                            </div>
                        @else
                            <div class="tool_item">
                                <a href="{{ route('site.product', ['id' => $item->attributes['id'], 'slug' => $item->attributes['slug']]) }}"
                                    class="cover">
                                    <img
                                        src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $item->attributes['image'],\Carbon\Carbon::now()->addMinutes(120)) }}" />
                                </a>
                                <form class="cont add-to-cart-form" method="post"
                                    action="{{ route('site.product.cart.add', ['id' => $item->attributes['id']]) }}">
                                    @csrf
                                    @method('post')
                                    <input type="hidden" name="type" id="quantity-type">
                                    <a
                                        href="{{ route('site.product', ['id' => $item->attributes['id'], 'slug' => $item->attributes['slug']]) }}">
                                        {{ $item->name }} </a>
                                    <p>{{ $item->getPriceSum() }} جنيه</p>
                                    <div class="cat-number">
                                        <a href="#" class="number-down">
                                            <i class="icon icon-minus"></i>
                                        </a>
                                        <input min="1" value="{{ $item->quantity }}" class="form-control" type="number"
                                            name="quantity" />
                                        <a href="#" class="number-up">
                                            <i class="icon icon-add"></i>
                                        </a>
                                    </div>
                                    <button class="link" type="submit" style="margin-bottom: 0; !important">
                                        <span>
                                            <i class="icon icon-shopping-cart"></i> تحديث العربة
                                        </span>
                                    </button>
                                </form>

                                <button class="icon_link icon icon-cross remove_btn"
                                    data-url="{{ route('site.cart.delete', ['id' => $item->id]) }}"></button>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="col-lg-5">
                    <div class="block-item">
                        <div class="form-title">تفاصيل الدفع</div>
                        <form method="post" action="{{ route('site.cart.discount') }}" class="discount-form">
                            @csrf
                            @method('post')
                            <div class="form-group promo_form">
                                <label> هل لديك كود خصم </label>
                                <input type="text" class="form-control" placeholder="إدخل الكود" name="discount" />
                                <button class="link" type="submit">
                                    <span> تفعيل الكود</span>
                                </button>
                            </div>
                            <hr class="w-100" />

                            <div class="cart-total">
                                <ul>
                                    <li>
                                        الإجـمـالـي :
                                        <span id="cart-total"> {{ \Cart::getTotal() }} جنيه </span>
                                    </li>
                                </ul>
                                @if (auth()->guard('site')->check())
                                    @if (\Cart::getContent()->count() > 0)
                                        <a href="{{ route('site.checkout.index') }}" class="link">
                                            <span> إستكمال الدفع </span>
                                        </a>
                                    @else
                                        <a href="javascript:;" class="link">
                                            <span> إستكمال التسوق </span>
                                        </a>
                                    @endif
                                @else
                                    <a href="javascript:;" class="link login-link">
                                        <span> إستكمال الدفع </span>
                                    </a>
                                @endif

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
        $(".add-to-cart-form").on('submit', function(e) {

            var url = $(this).attr('action');

            $.ajax({
                url: url,
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    notification("success", response.message, "fas fa-check");
                    $('#cart-count').html(response.counter);
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                },
                error: function(jqXHR) {
                    var response = $.parseJSON(jqXHR.responseText);
                    notification("danger", response, "fas fa-times");
                }
            });

            return false;
        });

        $(document).on('click', '.remove_btn', function() {
            window.location.href = $(this).data('url');
        });

        $(document).on('submit', '.discount-form', function() {
            var url = $(this).attr('action');
            var form = $(this);
            form.find(":submit").attr('disabled', true).html('<span> برجاء الإنتظار</span>');

            $.ajax({
                url: url,
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    form.find(":submit").attr('disabled', false).html('<span> تفعيل الكود</span>');
                    $('#cart-total').html(response + ' جنيه');

                },
                error: function(jqXHR) {
                    var response = $.parseJSON(jqXHR.responseText);
                    form.find(":submit").attr('disabled', false).html('<span> تفعيل الكود</span>');
                    notification("danger", response, "fas fa-times");
                }
            });

            return false;
        });

        $(document).on('click', '.login-link', function() {
            notification("danger", "برجاء تسجيل الدخول أولا لإستكمال الدفع", "fas fa-times");
            return false;
        });
    </script>
@endpush
