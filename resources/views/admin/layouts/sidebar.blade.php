<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('site/images/logo.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item ">
                    <a href="{{ route('admin.index') }}"
                        class="nav-link {{ request()->routeIs('admin.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            لوحة المراقبة
                        </p>
                    </a>
                </li>
                @can('settings-edit')
                    <li class="nav-item">
                        <a href="{{ route('admin.settings.index') }}"
                            class="nav-link {{ request()->routeIs('admin.settings.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                                إعدادات الموقع
                            </p>
                        </a>
                    </li>
                @endcan
                @if (auth()->user()->can('about-edit') ||
                    auth()->user()->can('features-list') ||
                    auth()->user()->can('team-list') ||
                    auth()->user()->can('investor-list'))
                    <li
                        class="nav-item {{ request()->routeIs('admin.investors.index') || request()->routeIs('admin.team.index') || request()->routeIs('admin.about.index') || request()->routeIs('admin.features.index') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.about.index') ? 'active ' : '' }}">
                            <i class="nav-icon fas fa-info"></i>
                            <p>
                                من نحن
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('about-edit')
                                <li class=" nav-item {{ request()->routeIs('admin.about.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.about.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.about.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>من نحن</p>
                                    </a>
                                </li>
                            @endcan
                            @can('features-list')
                                <li class=" nav-item {{ request()->routeIs('admin.features.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.features.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.features.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>المميزات</p>
                                    </a>
                                </li>
                            @endcan
                            @can('team-list')
                                <li class=" nav-item {{ request()->routeIs('admin.team.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.team.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.team.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>فريق العمل</p>
                                    </a>
                                </li>
                            @endcan
                            @can('investor-list')
                                <li class=" nav-item {{ request()->routeIs('admin.investors.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.investors.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.investors.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>المستثمرين</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->can('course-category-list') ||
                    auth()->user()->can('course-list'))
                    <li
                        class="nav-item {{ request()->routeIs('admin.courses.lectures.videos.index') || request()->routeIs('admin.courses.lectures.index') || request()->routeIs('admin.courses.lectures.create') || request()->routeIs('admin.courses.lectures.edit') || request()->routeIs('admin.courses.index') || request()->routeIs('admin.courses.create') || request()->routeIs('admin.courses.edit') || request()->routeIs('admin.courses.category.index') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->routeIs('admin.courses.category.index') ? 'active ' : '' }}">
                            <i class="nav-icon fas fa-list"></i>
                            <p>
                                الدورات التدريبية
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('course-category-list')
                                <li
                                    class=" nav-item {{ request()->routeIs('admin.courses.category.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.courses.category.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.courses.category.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>الأقسام</p>
                                    </a>
                                </li>
                            @endcan
                            @can('course-list')
                                <li class=" nav-item ">
                                    <a href="{{ route('admin.courses.index', ['type' => 'paid']) }}"
                                        class="nav-link ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>الدورات المدفوعة</p>
                                    </a>
                                </li>
                                <li class=" nav-item ">
                                    <a href=" {{ route('admin.courses.index', ['type' => 'free']) }}"
                                        class="nav-link ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>الدورات المجانية</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->can('product-category-list') ||
                    auth()->user()->can('products-list'))
                    <li
                        class="nav-item {{ request()->routeIs('admin.products.gallery.index') || request()->routeIs('admin.products.index') || request()->routeIs('admin.products.create') || request()->routeIs('admin.products.edit') || request()->routeIs('admin.products.category.index') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->routeIs('admin.products.category.index') ? 'active ' : '' }}">
                            <i class="nav-icon fas fa-list"></i>
                            <p>
                                خامات وأدوات
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('product-category-list')
                                <li
                                    class=" nav-item {{ request()->routeIs('admin.products.category.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.products.category.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.products.category.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>الأقسام</p>
                                    </a>
                                </li>
                            @endcan
                            @can('products-list')
                                <li
                                    class=" nav-item {{ request()->routeIs('admin.products.gallery.index') || request()->routeIs('admin.products.index') || request()->routeIs('admin.products.create') || request()->routeIs('admin.products.edit') ? 'active' : '' }}">
                                    <a href="{{ route('admin.products.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.products.gallery.index') || request()->routeIs('admin.products.index') || request()->routeIs('admin.products.create') || request()->routeIs('admin.products.edit') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>المنتجات</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->can('packages-list') ||
                    auth()->user()->can('membership-benefit-list'))
                    <li
                        class="nav-item {{ request()->routeIs('admin.packages.index') || request()->routeIs('admin.membership.index') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->routeIs('admin.packages.index') || request()->routeIs('admin.membership.index') ? 'active ' : '' }}">
                            <i class="nav-icon fas fa-box"></i>
                            <p>
                                أنظمه الإشتراك
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('packages-list')
                                <li class=" nav-item {{ request()->routeIs('admin.packages.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.packages.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.packages.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>الباقات</p>
                                    </a>
                                </li>
                            @endcan
                            @can('membership-benefit-list')
                                <li class=" nav-item {{ request()->routeIs('admin.membership.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.membership.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.membership.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>مميزات العضوية</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif
                @can('trainers-list')
                    <li class="nav-item">
                        <a href="{{ route('admin.trainers.index') }}"
                            class="nav-link {{ request()->routeIs('admin.trainers.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                المدربين
                            </p>
                        </a>
                    </li>
                @endcan
                @if (auth()->user()->can('admin-list') ||
                    auth()->user()->can('role-list'))
                    <li
                        class="nav-item {{ request()->routeIs('admin.admins.index') || request()->routeIs('admin.roles.index') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->routeIs('admin.admins.index') || request()->routeIs('admin.roles.index') ? 'active ' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                المستخدمين
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('admin-list')
                                <li class=" nav-item {{ request()->routeIs('admin.admins.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.admins.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.admins.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>المستخدمين</p>
                                    </a>
                                </li>
                            @endcan
                            @can('role-list')
                                <li class=" nav-item {{ request()->routeIs('admin.roles.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.roles.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.roles.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>الأدوار</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->can('company-list') ||
                    auth()->user()->can('company-gallery-list'))
                    <li
                        class="nav-item {{ request()->routeIs('admin.company.index') || request()->routeIs('admin.company.gallery.index') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->routeIs('admin.company.index') || request()->routeIs('admin.company.gallery.index') ? 'active ' : '' }}">
                            <i class="nav-icon fas fa-building"></i>
                            <p>
                                الشركات والمؤسسات
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('company-list')
                                <li class=" nav-item {{ request()->routeIs('admin.company.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.company.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.company.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>الطلبات</p>
                                    </a>
                                </li>
                            @endcan
                            @can('company-gallery-list')
                                <li
                                    class=" nav-item {{ request()->routeIs('admin.company.gallery.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.company.gallery.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.company.gallery.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>معرض الصور </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif
                @can('coupones-list')
                    <li class="nav-item">
                        <a href="{{ route('admin.coupones.index') }}"
                            class="nav-link {{ request()->routeIs('admin.coupones.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-dollar-sign"></i>
                            <p>
                                الكوبونات
                            </p>
                        </a>
                    </li>
                @endcan

                @can('article-list')
                    <li class="nav-item">
                        <a href="{{ route('admin.articles.index') }}"
                            class="nav-link {{ request()->routeIs('admin.articles.create') || request()->routeIs('admin.articles.index') || request()->routeIs('admin.articles.edit') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-newspaper"></i>
                            <p>
                                المدونة
                            </p>
                        </a>
                    </li>
                @endcan
                @can('messages-list')
                    <li class="nav-item">
                        <a href="{{ route('admin.messages.index') }}"
                            class="nav-link {{ request()->routeIs('admin.messages.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-envelope"></i>
                            <p>
                                رسائل التواصل
                                <span class="badge badge-info right">{{ \App\Models\Message::count() }}</span>
                            </p>

                        </a>
                    </li>
                @endcan
                @can('subscribers-list')
                    <li class="nav-item">
                        <a href="{{ route('admin.subscribers.index') }}"
                            class="nav-link {{ request()->routeIs('admin.subscribers.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                النشرة الإخباريه
                                <span class="badge badge-info right">{{ \App\Models\Subscriber::count() }}</span>
                            </p>
                        </a>
                    </li>
                @endcan
                @can('social-list')
                    <li class="nav-item">
                        <a href="{{ route('admin.social.index') }}"
                            class="nav-link {{ request()->routeIs('admin.social.create') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-link"></i>
                            <p>
                                روابط التواصل الإجتماعي
                            </p>
                        </a>
                    </li>
                @endcan
                @if (auth()->user()->can('faq-category-list') ||
                    auth()->user()->can('faqs-list'))
                    <li
                        class="nav-item {{ request()->routeIs('admin.faqs.category.index') || request()->routeIs('admin.faqs.index') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->routeIs('admin.faqs.category.index') || request()->routeIs('admin.faqs.index') ? 'menu-open' : '' }}">
                            <i class="nav-icon fas fa-question"></i>
                            <p>
                                الأسئله الشائعه
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('faq-category-list')
                                <li
                                    class="nav-item {{ request()->routeIs('admin.faqs.category.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.faqs.category.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.faqs.category.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            الأقسام
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('faqs-list')
                                <li class="nav-item {{ request()->routeIs('admin.faqs.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.faqs.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.faqs.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            الأسئلة الشائعة
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif
                {{-- <li class="nav-item">
                    <a href="{{ route('admin.permissions.index') }}"
                        class="nav-link {{ request()->routeIs('admin.permissions.create') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-link"></i>
                        <p>
                            الأذونات
                        </p>
                    </a>
                </li> --}}
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
