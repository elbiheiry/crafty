<div class="col-lg-3">
    <div class="profile_head">
        <div class="img">
            @if (request()->routeIs('site.profile.update'))
                <div class="upload_img">
                    <input type="file" name="image">
                    <i class="icon icon-write icon_link"></i>
                </div>
            @endif

            <img src="{{ $user->user_image() }}" alt="" />
        </div>
        <h3>{{ $user->name }}</h3>
        <ul class="profile_links">
            <li
                class="{{ request()->routeIs('site.profile.index') ||request()->routeIs('site.profile.update') ||request()->routeIs('site.profile.update_password')? 'active': '' }}">
                <a href="{{ route('site.profile.index') }}">
                    <i class="icon icon-user"></i> الملف الشخصى
                </a>
            </li>
            <li class="{{ request()->routeIs('site.profile.courses') ? 'active' : '' }}">
                <a href="{{ route('site.profile.courses') }}">
                    <i class="icon icon-video-camera"></i> دوراتى التدريبية
                </a>
            </li>

            <li class="{{ request()->routeIs('site.profile.products') ? 'active' : '' }}">
                <a href="{{ route('site.profile.products') }}">
                    <i class="icon icon-shopping-cart"></i> خامات وأدوات
                </a>
            </li>
            <li class="{{ request()->routeIs('site.profile.subscribtions') ? 'active' : '' }}">
                <a href="{{ route('site.profile.subscribtions') }}">
                    <i class="icon icon-access_time"></i> الإشتراكات
                </a>
            </li>
            <li class="{{ request()->routeIs('site.profile.orders') ? 'active' : '' }}">
                <a href="{{ route('site.profile.orders') }}">
                    <i class="fas fa-info"></i> الطلبات
                </a>
            </li>
            <li>
                <button class="link" type="button" onclick="$('#logout-form').submit()">
                    <span> <i class="icon icon-logout"></i> تسجيل خروج</span>
                </button>
            </li>
        </ul>
    </div>
</div>
