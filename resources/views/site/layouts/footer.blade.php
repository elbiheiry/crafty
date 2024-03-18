<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <img src="{{ asset('site/images/logo.png') }}" class="logo" />
                <ul class="row">
                    <li class="col-lg-12 col-md-6 col-sm-6 col-6">
                        <a href="{{ route('site.about') }}"> عن كرافتى </a>
                    </li>
                    <li class="col-lg-12 col-md-6 col-sm-6 col-6">
                        <a href="{{ route('site.blog') }}"> المدونة </a>
                    </li>
                    <li class="col-lg-12 col-md-6 col-sm-6 col-6">
                        <a href="{{ route('site.contact') }}"> تواصل معنا </a>
                    </li>
                </ul>
            </div>
            <!--End Col-->
            <div class="col-lg-3 col-md-6">
                <h3>لينكات سريعة</h3>
                <ul class="row">
                    <li class="col-lg-12 col-md-6 col-sm-6 col-6">
                        <a href="{{ route('site.courses') }}">الدورات التدريبية </a>
                    </li>
                    <li class="col-lg-12 col-md-6 col-sm-6 col-6">
                        <a href="{{ route('site.products') }}"> الخامات والأدوات</a>
                    </li>
                    <li class="col-lg-12 col-md-6 col-sm-6 col-6">
                        <a href="{{ route('site.free_courses') }}">دورات مجانية </a>
                    </li>
                    <li class="col-lg-12 col-md-6 col-sm-6 col-6">
                        <a href="{{ route('site.packages') }}"> أنظمة الاشتراك </a>
                    </li>
                    <li class="col-lg-12 col-md-6 col-sm-6 col-6">
                        <a href="{{ route('site.trainers') }}"> سجل كمدرب </a>
                    </li>
                    <li class="col-lg-12 col-md-6 col-sm-6 col-6">
                        <a href="{{ route('site.companies') }}">المؤسسات والشركات</a>
                    </li>
                </ul>
            </div>
            <!--End Col-->

            <div class="col-lg-3 col-md-6">
                <h3>مساعدة</h3>
                <ul class="row">
                    <li class="col-lg-12 col-md-6 col-sm-6 col-6">
                        <a href="{{ route('site.terms') }}">الشروط والأحكام </a>
                    </li>
                    <li class="col-lg-12 col-md-6 col-sm-6 col-6">
                        <a href="{{ route('site.privacy') }}"> سياسة الخصوصية</a>
                    </li>
                    <li class="col-lg-12 col-md-6 col-sm-6 col-6">
                        <a href="{{ route('site.faqs') }}">الأسئلة الشائعة </a>
                    </li>
                </ul>
            </div>
            <!--End Col-->
            <div class="col-lg-3 col-md-6">
                <h3>إتصل بنا</h3>
                <ul class="footer_contact">
                    <li class="d-block w-100">
                        <a href="mailto:{{ $settings->email }}">
                            <i class="icon icon-mail"></i>
                            <span> {{ $settings->email }} </span>
                        </a>
                    </li>
                    <li class="d-block w-100">
                        <a href="tel:+{{ $settings->phone }}">
                            <i class="icon icon-phone"></i>
                            <span> {{ $settings->phone }} </span>
                        </a>
                    </li>
                </ul>
                <h3>تابعنا على مواقع التواصل الأجتماعى</h3>
                <ul class="social">
                    @foreach ($links as $link)
                        <li>
                            <a target="_blank" href="{{ $link->link }}"
                                class="icon_link icon icon-{{ $link->name }}">
                            </a>
                        </li>
                    @endforeach
                </ul>
                <p>جميع الحقوق محفوظة © 2022</p>
            </div>
        </div>
        <!--End Row-->
    </div>
    <!--End Container-->
</footer>
