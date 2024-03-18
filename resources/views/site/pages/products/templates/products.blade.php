@php
$x = 30;
@endphp
@foreach ($products as $product)
    <div class="col-lg-3 col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="{{ $x }}">
        <div class="tool_item">
            <a href="{{ route('site.product', ['id' => $product->id, 'slug' => $product->slug]) }}"
                class="cover">
                {{-- <img src="{{ get_image($product->image, 'products') }}" /> --}}
                <img
                    src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $product->image,\Carbon\Carbon::now()->addMinutes(120)) }}" />
            </a>
            <div class="cont">
                <a
                    href="{{ route('site.product', ['id' => $product->id, 'slug' => $product->slug]) }}">{{ $product->translate(app()->getLocale())->name }}</a>
                <p>{{ $product->price }} جنيه</p>
                <div class="w-100">
                    <button class="icon_link icon icon-bookmark wishlist-btn"
                        data-url="{{ route('site.product.wishlist', ['id' => $product->id]) }}"></button>
                    <button class="link add-to-cart"
                        data-url="{{ route('site.product.cart.add', ['id' => $product->id]) }}">
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
    @php
        $x += 30;
    @endphp
@endforeach
