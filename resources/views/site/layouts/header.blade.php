<header>
    <div class="container">
        <div class="row">
            <div class="col">
                <a href="{{ route('site.index') }}" class="logo">
                    <img src="{{ asset('site/images/logo.png') }}" />
                </a>
                <ul class="header_btns">
                    <li>
                        <button class="icon_link icon icon-search search_btn" type="button"></button>
                    </li>
                    <li>
                        <a href="{{ route('site.cart') }}" class="icon_link cart">
                            <i class="icon icon-shopping-cart"></i>
                            <span id="cart-count"> {{ \Cart::getContent()->count() }}</span>
                        </a>
                    </li>
                    @if (auth()->guard('site')->check())
                        <li>
                            <a class="link" href="{{ route('site.profile.index') }}">
                                <span>
                                    <i class="icon icon-user"></i>
                                    الملف الشخصي
                                </span>
                            </a>
                        </li>
                        <li>
                            <a class="link" href="javascript:;" onclick="$('#logout-form').submit()">
                                <span>
                                    <i class="icon icon-unlock"></i>
                                    تسجيل خروج
                                </span>
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('site.login') }}" class="link">
                                <span>
                                    <i class="icon icon-lock"></i>
                                    تسجيل دخول
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('site.register') }}" class="link">
                                <span>
                                    <i class="icon icon-user"></i>
                                    إنشاء حساب
                                </span>
                            </a>
                        </li>
                    @endif


                    <li>
                        <button class="menu-btn icon_link" type="button" data-toggle="collapse" data-target="#main-nav">
                            <i class="icon icon-bar_chart"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        <form class="search_form" method="get" action="{{ route('site.search') }}">
            <input type="text" class="form-control" placeholder="ما الذى تبحث عنه ..." name="search" />
            <button class="icon_link icon icon-search" type="submit"></button>
            <button class="icon_link icon icon-cross search_btn" type="button"></button>
        </form>
    </div>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="collapse navbar-collapse" id="main-nav">
                        <ul class="navbar-nav">
                            <li class="{{ request()->routeIs('site.index') ? 'active' : '' }}">
                                <a href="{{ route('site.index') }}"> الرئيسية </a>
                            </li>

                            <li
                                class="dropdown {{ request()->routeIs('site.courses') || request()->routeIs('site.course') ? 'active' : '' }}">
                                <a href="{{ route('site.courses') }}"> الدورات التـدريبية </a>
                                <a href="#" class="extra" data-toggle="dropdown">
                                    <i class="icon icon-chevron-down"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @foreach (\App\Models\CourseCategory::all()->sortByDesc('id') as $category)
                                        <div class="sub_dropdown">
                                            <a href="{{ route('site.courses', ['id' => $category->id, 'slug' => $category->slug]) }}"
                                                class="extra" data-toggle="sub_dropdown">
                                                {{ $category->translate(app()->getLocale())->name }}
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </li>
                            <li
                                class="{{ request()->routeIs('site.products') || request()->routeIs('site.product') ? 'active' : '' }}">
                                <a href="{{ route('site.products') }}"> خـامـات وأدوات </a>
                            </li>
                            <li class="{{ request()->routeIs('site.trainers') ? 'active' : '' }}">
                                <a href="{{ route('site.trainers') }}"> سـجـل كـمـدرب</a>
                            </li>
                            <li class="{{ request()->routeIs('site.packages') ? 'active' : '' }}">
                                <a href="{{ route('site.packages') }}"> أنـظـمـة الاشـتـراك </a>
                            </li>

                            <li class="{{ request()->routeIs('site.contact') ? 'active' : '' }}">
                                <a href="{{ route('site.contact') }}"> تواصل معنا </a>
                            </li>
                            @if (!auth()->guard('site')->check())
                                <li>
                                    <a href="{{ route('site.login') }}"> تسجيل دخول </a>
                                </li>

                                <li>
                                    <a href="{{ route('site.register') }}"> إنشاء حساب </a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ route('site.profile.index') }}">
                                        الملف الشخصي
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" onclick="$('#logout-form').submit()">
                                        تسجيل خروج
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!--End Nav-->
</header>
<form id="logout-form" action="{{ route('site.logout') }}" method="post">
    @csrf
</form>
