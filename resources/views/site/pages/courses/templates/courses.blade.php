@php
$x = 80;
@endphp
@foreach ($courses as $course)
    @if ($course->price != null)
        <div class="col-lg-4 col-md-6 col-sm-6" data-aos="fade-up" data-aos-delay="{{ $x }}">
            <div class="course">
                <div class="cover">
                    @if ($course->discount != 0 || $course->discount)
                        <span class="status"> خصم {{ $course->discount }} </span>
                    @endif

                    <div class="act">
                        <button class="icon_link icon icon-bookmark wishlist-btn"
                            data-url="{{ route('site.course.wishlist', ['id' => $course->id]) }}"></button>
                    </div>
                    <a href="{{ route('site.course', ['id' => $course->id, 'slug' => $course->slug]) }}">
                        <img
                            src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $course->image,\Carbon\Carbon::now()->addMinutes(120)) }}" />
                    </a>
                </div>
                <div class="cont">
                    <span class="category">
                        {{ $course->category->translate(app()->getLocale())->name }}
                    </span>
                    <span class="category"> {{ $course->get_level() }}</span>

                    <a href="{{ route('site.course', ['id' => $course->id, 'slug' => $course->slug]) }}"
                        class="title">{{ $course->translate(app()->getLocale())->name }}</a>
                    <div class="inst">
                        <img
                            src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $course->lecturer_image,\Carbon\Carbon::now()->addMinutes(120)) }}" />
                        {{ $course->translate(app()->getLocale())->lecturer_name }}
                    </div>
                </div>
                <div class="sub_info">
                    @if (!in_array($course->id, $course_ids))
                        <button class="link add-to-cart"
                            data-url="{{ route('site.course.cart.add', ['id' => $course->id]) }}">
                            <span>
                                <i class="icon icon-shopping-cart"></i>
                                {{ $course->price_after_discount() }} جنيه
                            </span>
                        </button>
                    @endif
                    <span class="num_lesson">
                        <i class="icon icon-eye"></i>
                        {{ $course->views }}
                    </span>
                </div>
            </div>
            <!--End Course-->
        </div>
    @else
        <div class="col-lg-4 col-md-6 col-sm-6" data-aos="fade-up" data-aos-delay="{{ $x }}">
            <div class="course">
                <div class="cover">
                    <div class="act">
                        <button class="icon_link icon icon-bookmark wishlist-btn"
                            data-url="{{ route('site.course.wishlist', ['id' => $course->id]) }}"></button>
                    </div>
                    <a href="{{ route('site.course', ['id' => $course->id, 'slug' => $course->slug]) }}">
                        <img
                            src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $course->image,\Carbon\Carbon::now()->addMinutes(120)) }}" />
                    </a>
                </div>

                <div class="cont">
                    <span class="category">
                        {{ $course->category->translate(app()->getLocale())->name }}
                    </span>
                    <span class="category"> {{ $course->get_level() }}</span>

                    <a href="{{ route('site.course', ['id' => $course->id, 'slug' => $course->slug]) }}"
                        class="title">{{ $course->translate(app()->getLocale())->name }}</a>
                    <div class="inst">
                        <img
                            src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $course->lecturer_image,\Carbon\Carbon::now()->addMinutes(120)) }}" />
                        {{ $course->translate(app()->getLocale())->lecturer_name }}
                    </div>
                </div>
                <div class="sub_info">
                    <button class="link">
                        <span>
                            مــجــانــا
                        </span>
                    </button>
                    <span class="num_lesson">
                        <i class="icon icon-eye"></i>
                        {{ $course->views }}
                    </span>
                </div>
            </div>
            <!--End Course-->
        </div>
    @endif
    @php
        $x += 40;
    @endphp
@endforeach
