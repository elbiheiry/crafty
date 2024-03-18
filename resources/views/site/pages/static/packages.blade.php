@extends('site.layouts.master')
@section('content')
    <!-- Section ==========================================-->
    <section class="package_head video_wrap">
        <div class="container">
            <div class="row">
                <video autoplay loop width="100%" height="520" muted>
                    <source src="{{ asset('site/images/video.mp4') }}" />
                </video>
                <div class="caption">
                    <h3>جعل حياة الناس أفضل من خلال الإبداع</h3>
                    <p>
                        انضم الآن لمشاهدة أكثر من 1500 فيديو تعليمى بقيادة متخصصين في هذا
                        المجال
                    </p>
                    <a href="#next" class="link">
                        <span> إشترك الآن </span>
                    </a>
                </div>
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
    <!--End Section-->
    <!-- Section ==========================================-->
    <section class="packages pt-0" id="next">
        <div class="container-fluid">
            <div class="row">
                <ul class="pacakge_categ col-12">
                    @foreach ($categories as $category)
                        <li>
                            <a href="{{ route('site.courses', ['id' => $category->id, 'slug' => $category->slug]) }}">
                                {{-- <img src="{{ get_image($category->image, 'courses') }}" alt="" /> --}}
                                <img
                                    src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $category->image,\Carbon\Carbon::now()->addMinutes(120)) }}" />
                                {{ $category->translate(app()->getLocale())->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-12 text-right text-md-center" data-aos="fade-up" data-aos-delay="40">
                    <div class="about_cont flex">
                        <h3>أفضل الأسعار لخطط الاشتراك</h3>
                        <p>
                            اختر خطة عضويتك واحصل على أفضل الفئات والمشاريع المتميزة لدينا
                            مع وصول 24/7 إلى النصائح والتقنيات من خبرائنا ، والتجديد
                            التلقائي ، وسياسة الإلغاء في أي وقت.
                        </p>
                    </div>
                </div>
                <!--End Col-->
                @foreach ($packages as $package)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="package_item">
                            <img
                                src="{{ \Storage::disk('s3.assets')->temporaryUrl('assets/' . $package->image,\Carbon\Carbon::now()->addMinutes(120)) }}" />
                            <h3>{{ $package->translate(app()->getLocale())->name }}</h3>
                            <div class="price">
                                <span> {{ $package->price }} </span>
                                جنيه
                                <sub>{{ $package->get_type() }} </sub>
                            </div>
                            <div class="action">
                                <button class="link subscribe-btn"
                                    data-url="{{ route('site.packages.subscribe', ['id' => $package->id]) }}">
                                    <span> الأشتراك الآن </span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
    <!--End Section-->
    <!-- Section ==========================================-->
    <section class="section_color packages">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 text-center">
                    <div class="section_title">
                        <h3 style="font-size: 32px; margin-bottom: 35px">
                            مـزايـا الـعـضـويـة
                        </h3>
                    </div>
                </div>
                <!--End Col-->
                @foreach ($benefits as $benefit)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="benefits_item">
                            <i class="icon icon-check"></i>
                            <h3>{{ $benefit->translate(app()->getLocale())->title }}</h3>
                            <p>{{ $benefit->translate(app()->getLocale())->description }}</p>
                        </div>
                    </div>
                    <!--End Col-->
                @endforeach
            </div>
        </div>
    </section>
    <!-- Section ==========================================-->
    <section class="start_sec">
        <div class="container">
            <div class="row justify-content-center align-items-center col-lg-10 m-auto">
                <div class="col-12 text-center">
                    <div class="section_title">
                        <h3 style="font-size: 32px; margin-bottom: 35px">ابدأ الآن</h3>
                    </div>
                </div>
                <!--End Col-->
                <div class="col-sm-6">
                    <div class="start_item">
                        <i class="icon icon-bookmark"></i>
                        <h3>حدد عضويتك</h3>
                        <p>اختر بين العضوية المميزة الشهرية أو السنوية.</p>
                    </div>
                </div>
                <!--End Col-->
                <div class="col-sm-6">
                    <div class="start_item">
                        <i class="icon icon-files"></i>
                        <h3>اختر المحتوى الخاص بك</h3>
                        <p>تصفح مكتبتنا للصفوف والمشاريع التي يدرسها سادة صناعاتهم.</p>
                    </div>
                </div>
                <!--End Col-->
                <div class="col-sm-6">
                    <div class="start_item">
                        <i class="icon icon-video-camera"></i>
                        <h3>تعلم وابتكر</h3>
                        <p>
                            ابدأ في مشروعك التالي على الفور! تعلم بالسرعة التي تناسبك - في
                            أي وقت وفي أي مكان.
                        </p>
                    </div>
                </div>
                <!--End Col-->
                <div class="col-sm-6">
                    <div class="start_item">
                        <i class="icon icon-share"></i>
                        <h3>مشاركة العضوية</h3>
                        <p>
                            لدى كرافتسي ما يستمتع به الجميع. شارك عضويتك مع ما يصل إلى ثلاثة
                            أفراد من العائلة أو الأصدقاء.
                        </p>
                    </div>
                </div>
                <!--End Col-->
            </div>
        </div>
    </section>
    <!-- Section ==========================================-->
    <section class="packages wide">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 about_cont p-50">
                    <h3>اصنع مع الخبراء</h3>
                    <p>
                        أيًا كان ما ترغب في إنشائه ، تمنحك Craftsy الأدوات اللازمة لإنجاز
                        المهمة. سواء كان الأمر يتعلق بالخياطة أو الطهي أو الخبز أو الرسم ،
                        فنحن هنا لتمكينك وإلهامك ومساعدتك على تحسين مهاراتك. لدينا خبراء
                        موهوبون يقومون بالتدريس عبر أكثر من 20 فئة. كن عضوا وانضم إلى
                        مجتمعنا اليوم!
                    </p>
                    <a href="{{ route('site.trainers') }}" class="link big_btn">
                        <span> سـجـل كـمـدرب </span>
                    </a>
                </div>
                <!--End col-->
                <div class="col-lg-6 about_img">
                    <img src="{{ asset('site/images/packages.png') }}" />
                </div>
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
@endsection
@push('js')
    <script>
        $(document).on('click', '.subscribe-btn', function() {
            var url = $(this).data('url');

            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    window.location.href = response;
                },
                error: function(jqXHR) {
                    var response = $.parseJSON(jqXHR.responseText);

                    notification("danger", response, "fas fa-times");

                }
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                }
            });
            return false;
        });
    </script>
@endpush
