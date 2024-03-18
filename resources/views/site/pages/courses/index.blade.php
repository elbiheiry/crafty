@extends('site.layouts.master')
@section('content')
    <!-- Section ==========================================-->
    <section class="page_head">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>{{ $category ? $category->translate(app()->getLocale())->ar : 'الدورات التدريبية' }}</h3>
                    <ul>
                        <li>
                            <a href="{{ route('site.index') }}"> الرئيسية </a>
                        </li>
                        <li>{{ $category ? $category->translate(app()->getLocale())->ar : 'الدورات التدريبية' }}</li>
                    </ul>
                </div>
                <!--End Col-->
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
    <!--End Section-->
    <!-- Sectio ==========================================-->
    <section class="section_color courses">
        <div class="container">
            @if ($courses->count() > 0)
                <div class="row up_view">
                    <div class="col-12" data-aos="fade-up" data-aos-delay="40">
                        <div class="accordion accordion_filter" id="filter">
                            @csrf
                            <div class="panel">
                                <a href="#toggle1" data-toggle="collapse" class="collapsed panel-title">
                                    المستوى
                                </a>
                                <!--End panel-title-->
                                <div class="panel-collapse collapse shadow" id="toggle1" data-parent="#filter">
                                    <div class="form-group">
                                        <input id="level0" type="checkbox" name="all_levels" class="levels" />
                                        <label for="level0">الكل</label>
                                    </div>
                                    <div class="form-group">
                                        <input id="level1" type="checkbox" name="levels[]" value="1"
                                            class="levels" />
                                        <label for="level1"> مبتدئ </label>
                                    </div>

                                    <div class="form-group">
                                        <input id="level2" type="checkbox" name="levels[]" value="2"
                                            class="levels" />
                                        <label for="level2"> متوسط </label>
                                    </div>
                                    <div class="form-group">
                                        <input id="level3" type="checkbox" name="levels[]" value="3"
                                            class="levels" />
                                        <label for="level3"> محترف</label>
                                    </div>
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
                </div>
                <div class="row" id="load-area">
                    @include('site.pages.courses.templates.courses')
                </div>
                <!--End Row-->
            @else
                <div class="alert alert-danger text-center">
                    لا توجد دورات تدريبيه حاليا في هذا القسم
                </div>
            @endif

        </div>
        <!--End Container-->
    </section>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('[name="all_levels"]').on('click', function() {

                if ($(this).is(':checked')) {
                    $.each($('.levels'), function() {
                        $(this).prop('checked', true);
                    });
                } else {
                    $.each($('.levels'), function() {
                        $(this).prop('checked', false);
                    });
                }

            });
        });
        $(document).on('change', '.levels , .order-input', function() {
            var levels = [];
            $('input[name="levels[]"]:checked').each(function() {
                levels.push($(this).val());
            });

            var url = "{{ url()->current() }}";
            var order = $(".order-input:checked").val();

            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    levels: levels,
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
