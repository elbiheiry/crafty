@foreach ($courses as $course)
    <div class="col-lg-4 col-md-6 col-sm-6" data-aos="fade-up" data-aos-delay="30">
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
@endforeach
