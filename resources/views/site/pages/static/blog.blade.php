@extends('site.layouts.master')
@section('content')
    <!-- Section ==========================================-->
    <section class="page_head">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>الأخــبــار</h3>
                    <ul>
                        <li>
                            <a href="{{ route('site.index') }}"> الرئيسية </a>
                        </li>
                        <li>الأخــبــار</li>
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
    <section class="blog section_color">
        <div class="container">
            <div class="col">
                <div class="row" id="load-area">
                    @include('site.pages.static.templates.articles')
                </div>
                @if ($articles->count() > 0)
                    <div class="col-12 text-center" data-aos="fade-up" data-aos-delay="120">
                        <button class="link more " data-url="{{ url()->current() }}" id="load-more-button"
                            data-last="{{ $articles->lastPage() }}" data-count="{{ $articles->currentPage() }}">
                            <span> مشاهدة المزيد </span>
                        </button>
                    </div>
                @endif
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
        @include('site.layouts.subscribe')
    </section>
@endsection
@push('js')
    <script>
        //load more button
        $(document).on('click', '#load-more-button', function() {

            var button = $(this);
            var url = button.data('url');
            var last_page = parseInt($(this).attr('data-last'));
            var counter = parseInt($(this).attr('data-count')) + 1;

            $.ajax({
                url: url,
                method: 'GET',
                data: {
                    page: counter,
                    _token: $('input[name="_token"]').val()
                },
                success: function(response) {
                    button.attr('data-count', counter);
                    if (counter + 1 > last_page) {
                        button.css('display', 'none');
                    }
                    $('#load-area').append(response);

                }
            });
            return false;
        });
    </script>
@endpush
