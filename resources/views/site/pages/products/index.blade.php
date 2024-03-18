@extends('site.layouts.master')
@section('content')
    <!-- Section ==========================================-->
    <section class="page_head">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>خامات وأدوات</h3>
                    <ul>
                        <li>
                            <a href="{{ route('site.index') }}"> الرئيسية </a>
                        </li>
                        <li>خامات وأدوات</li>
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
    <section class="tools">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="accordion accordion_filter" id="filter">
                        @csrf
                        <div class="panel">
                            <a href="#toggle1" data-toggle="collapse" class="collapsed panel-title">
                                القسم
                            </a>
                            <!--End panel-title-->
                            <div class="panel-collapse collapse shadow" id="toggle1" data-parent="#filter">
                                <div class="form-group">
                                    <input id="level0" type="checkbox" name="all_categories" class="categories" />
                                    <label for="level0">الكل</label>
                                </div>
                                @foreach ($categories as $index => $category)
                                    <div class="form-group">
                                        <input id="level{{ $index + 1 }}" type="checkbox" name="categories[]"
                                            value="{{ $category->id }}" class="categories" />
                                        <label for="level{{ $index + 1 }}">
                                            {{ $category->translate(app()->getLocale())->name }} </label>
                                    </div>
                                @endforeach
                            </div>
                            <!--End Panel Collapse-->
                        </div>
                        <!--End Panel-->

                        <div class="panel">
                            <a href="#toggle2" data-toggle="collapse" class="collapsed panel-title">
                                ترتيب النتائج حسب
                            </a>
                            <!--End panel-title-->
                            <div class="panel-collapse collapse shadow" id="toggle2" data-parent="#filter">
                                <div class="form-group">
                                    <input id="order0" type="radio" name="order" value="1" class="order-input" />
                                    <label for="order0"> الأقل سعراً </label>
                                </div>

                                <div class="form-group">
                                    <input id="order1" type="radio" name="order" value="2" class="order-input" />
                                    <label for="order1"> الأعلى سعراً </label>
                                </div>
                                <div class="form-group">
                                    <input id="order2" type="radio" name="order" value="3" class="order-input" />
                                    <label for="order2">المضافة حديثاً </label>
                                </div>
                                <div class="form-group">
                                    <input id="order3" type="radio" name="order" value="4" class="order-input" />
                                    <label for="order3"> الأكثر مبيعاً </label>
                                </div>
                            </div>
                            <!--End Panel Collapse-->
                        </div>
                        <!--End Panel-->
                    </div>
                </div>
                <div class="row" id="load-area">
                    @include('site.pages.products.templates.products')
                </div>
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('[name="all_categories"]').on('click', function() {

                if ($(this).is(':checked')) {
                    $.each($('.categories'), function() {
                        $(this).prop('checked', true);
                    });
                } else {
                    $.each($('.categories'), function() {
                        $(this).prop('checked', false);
                    });
                }

            });
        });
        $(document).on('change', '.categories , .order-input', function() {
            var categories = [];
            $('input[name="categories[]"]:checked').each(function() {
                categories.push($(this).val());
            });
            var url = "{{ url()->current() }}";
            var order = $(".order-input:checked").val();

            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    categories: categories,
                    order: order,
                    _token: $('input[name="_token"]').val()
                },
                success: function(response) {
                    $('#load-area').html(response);

                }
            });
            return false;
        });

        $(document).on('click', '.wishlist-btn', function() {
            var url = $(this).data('url');

            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    notification("success", response, "fas fa-check");
                },
                error: function(jqXHR) {
                    var response = $.parseJSON(jqXHR.responseText);
                    notification("danger", response, "fas fa-times");
                }
            });
            return false;
        })
    </script>
@endpush
