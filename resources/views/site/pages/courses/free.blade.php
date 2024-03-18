@extends('site.layouts.master')
@section('content')
    <!-- Section ==========================================-->
    <section class="page_head">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>دورات مجانية</h3>
                    <ul>
                        <li>
                            <a href="{{ route('site.index') }}"> الرئيسية </a>
                        </li>
                        <li> دورات مجانية </li>
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
    <section class="section_color courses">
        <div class="container">

            <div class="row">
                @include('site.pages.courses.templates.free_courses')
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
@endsection
@push('js')
    <script>
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
