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
    <!-- Section ==========================================-->
    <section class="section_color profile">
        <div class="container">
            <div class="row">
                @include('site.pages.profile.templates.sidebar')
                <div class="col-lg-9">
                    <div class="box">
                        <div class="box_title pb-0 pt-0">
                            <ul class="nav nav-tabs">
                                <li>
                                    <a data-toggle="tab" href="#t0" class="active">
                                        منتجاتى ({{ $products->count() }})
                                    </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#t1" class="">
                                        المنتجات المحفوظة ({{ $user->product_wishlists->count() }})
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="profile_form">
                            <div class="tab-content">
                                <div id="t0" class="tab-pane fade in active show">
                                    <div class="row">
                                        @if ($products->count() > 0)
                                            @foreach ($products as $product)
                                                <div class="col-lg-5 col-md-5 col-sm-6" data-aos="fade-up"
                                                    data-aos-delay="30">
                                                    <div class="tool_item">
                                                        <a href="{{ route('site.product', ['id' => $product->id, 'slug' => $product->slug]) }}"
                                                            class="cover">
                                                            <img
                                                                src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $product->image,\Carbon\Carbon::now()->addMinutes(120)) }}" />
                                                        </a>
                                                        <div class="cont">
                                                            <a
                                                                href="{{ route('site.product', ['id' => $product->id, 'slug' => $product->slug]) }}">
                                                                {{ $product->translate(app()->getLocale())->name }}
                                                            </a>
                                                            <p>{{ $product->price }} جنيه</p>
                                                            <div class="w-100">

                                                                <button class="icon_link icon icon-cross delete-btn"
                                                                    data-url="{{ route('site.product.wishlist.remove', ['id' => $product->id]) }}"></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--End Tool -->
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="alert alert-danger text-center">
                                                لا توجد أدوات أو خامات حاليا
                                            </div>
                                        @endif

                                    </div>
                                </div>
                                <div id="t1" class="tab-pane fade in">
                                    <div class="row">
                                        @if ($user->product_wishlists->count() > 0)
                                            @foreach ($user->product_wishlists as $wishlist)
                                                <div class="col-lg-5 col-md-5 col-sm-6" data-aos="fade-up"
                                                    data-aos-delay="30">
                                                    <div class="tool_item">
                                                        <a href="{{ route('site.product', ['id' => $wishlist->product->id, 'slug' => $wishlist->product->slug]) }}"
                                                            class="cover">
                                                            <img
                                                                src="{{ get_image($wishlist->product->image, 'products') }}" />
                                                            <img
                                                                src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $wishlist->product->image,\Carbon\Carbon::now()->addMinutes(120)) }}" />
                                                        </a>
                                                        <div class="cont">
                                                            <a
                                                                href="{{ route('site.product', ['id' => $wishlist->product->id, 'slug' => $wishlist->product->slug]) }}">
                                                                {{ $wishlist->product->translate(app()->getLocale())->name }}
                                                            </a>
                                                            <p>{{ $wishlist->product->price }} جنيه</p>
                                                            <div class="w-100">

                                                                <button class="icon_link icon icon-cross delete-btn"
                                                                    data-url="{{ route('site.product.wishlist.remove', ['id' => $wishlist->id]) }}"></button>
                                                                <button class="link">
                                                                    <span>
                                                                        <i class="icon icon-shopping-cart"></i>
                                                                        إضافة للعربة
                                                                    </span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--End Tool -->
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="alert alert-danger text-center">
                                                لا توجد أدوات أو خامات حاليا
                                            </div>
                                        @endif
                                    </div>
                                </div>
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
    <form method="post" id="delete-form" action="">
        @csrf
        @method('delete')
    </form>
@endsection
@push('js')
    <script>
        $(document).on('click', '.delete-btn', function() {
            var url = $(this).data('url');

            $('#delete-form').attr('action', url).submit();

        });
    </script>
@endpush
