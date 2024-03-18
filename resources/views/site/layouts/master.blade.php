<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
@include('site.layouts.head')

<body>
    @stack('models')
    <!-- Loadig
    ==========================================-->
    <div class="loading">
        <div class="load_cont">
            <i class="load_icon"></i>
        </div>
    </div>
    <!-- Header
    ==========================================-->
    @include('site.layouts.header')
    <!--End Header-->
    <!-- Section
    ==========================================-->
    @yield('content')
    <!-- Footer
    ==========================================-->
    @include('site.layouts.footer')
    <!--End Section-->
    <div class="support">
        <a target="_blank" href="https://www.facebook.com/780179545671260/" class="icon_link icon icon-telegram"> </a>
        <a target="_blank" href="https://wa.me/{{ $settings->phone }}" class="icon_link icon icon-whatsapp">
        </a>
    </div>
    <!-- Up Button
    ==========================================-->
    <button class="up_btn icon_link">
        <i class="icon icon-chevron-down"></i>
    </button>
    <!-- JS & Vendor Files
    ==========================================-->
    @include('site.layouts.scripts')
</body>

</html>
