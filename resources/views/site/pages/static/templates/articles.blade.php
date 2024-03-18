@foreach ($articles as $article)
    <div class="col-md-6" data-aos="fade-up" data-aos-delay="30">
        <a href="{{ route('site.article', ['id' => $article->id, 'slug' => $article->slug]) }}" class="blog_item">
            <div class="cover">
                {{-- <img src="{{ get_image($article->outer_image, 'articles') }}" /> --}}
                <img
                    src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $article->outer_image,\Carbon\Carbon::now()->addMinutes(120)) }}" />
            </div>
            <div class="cont">
                <h3>{{ $article->translate(app()->getLocale())->title }}</h3>
                <p>{{ $article->translate(app()->getLocale())->brief }} ...</p>
                <p class="text_link">
                    مشاهدة المزيد
                    <i class="icon icon-chevron-down"></i>
                </p>
            </div>
        </a>
        <!--End Blog-->
    </div>
@endforeach
