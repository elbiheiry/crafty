@extends('site.layouts.master')
@section('content')
    <section class="page_head">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form class="login wide register-form" method="post" action="{{ route('site.register') }}">
                        @csrf
                        @method('post')
                        <div class="row">
                            <div class="col-12">
                                <div class="section_title">
                                    <h3>إنشاء حساب</h3>
                                </div>
                            </div>
                            <div class="col-12">
                                <ul class="social-login">
                                    <li>
                                        <button type="button" class="link icon-facebook" onclick="fbLogin();" id="fbLink">
                                            <i class="icon icon-facebook"></i>
                                            تسجيل دخول عن طريق الفيسبوك
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" class="link icon-google google">
                                            <i class="icon icon-google"></i>
                                            تسجيل دخول عن طريقة جوجل
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-12">
                                <p class="spacer">
                                    <span>أو </span>
                                </p>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="الاسم بالكامل " name="name" />
                                    <i class="icon icon-user"></i>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="رقم االهاتف " name="phone" />
                                    <i class="icon icon-phone"></i>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="العنوان" name="address" />
                                    <i class="icon icon-location-pin"></i>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="البريد الإلكترونى "
                                        name="email" />
                                    <i class="icon icon-mail"></i>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="كلمة المرور"
                                        name="password" />
                                    <i class="icon icon-lock"></i>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="تأكيد كلمة المرور"
                                        name="password_confirmation" />
                                    <i class="icon icon-lock"></i>
                                </div>
                            </div>

                            <div class="col-12 text-center">
                                <button class="link" type="submit">
                                    <span> إنشاء حساب </span>
                                </button>
                                <div class="w-100"></div>
                                <a href="{{ route('site.login') }}"> لديك حساب ؟ سجل الآن</a>
                            </div>
                        </div>
                    </form>
                </div>
                <!--End Col-->
            </div>
            <!--End Row-->
        </div>
        <!--End Container-->
    </section>
@endsection
@push('js')
    <script>
        $(document).on('submit', '.register-form', function() {
            var form = $(this);
            var url = form.attr('action');
            var formData = new FormData(form[0]);
            form.find(":submit").attr('disabled', true).html('<span>إنتظر</span>');

            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    notification("success", "تم تسجيل الدخول بنجاح", "fas fa-check");
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                },
                error: function(jqXHR) {
                    var response = $.parseJSON(jqXHR.responseText);
                    var errors = [];
                    $.each(response.errors, function(index, value) {
                        errors.push(value);
                    });
                    notification("danger", errors[0], "fas fa-times");
                    form.find(":submit").attr('disabled', false).html("<span> إنشاء حساب </span>");
                }
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('input[name="_token"]').val()
                }
            });
            return false;
        });
        $('.google').on('click', function() {
            window.location.href = "{{ route('site.login.redirect', ['provider' => 'google']) }}"
        });

        window.fbAsyncInit = function() {
            // FB JavaScript SDK configuration and setup
            FB.init({
                appId: '415636873420259', // FB App ID
                cookie: true, // enable cookies to allow the server to access the session
                xfbml: true, // parse social plugins on this page
                version: 'v3.2' // use graph api version 2.8
            });

            // Check whether the user already logged in
            FB.getLoginStatus(function(response) {
                if (response.status === 'connected') {
                    //display user data
                    getFbUserData();
                }
            });
        };

        // Load the JavaScript SDK asynchronously
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        // Facebook login with JavaScript SDK
        function fbLogin() {
            FB.login(function(response) {
                if (response.authResponse) {
                    // Get and display the user profile data
                    getFbUserData();
                } else {
                    notification("danger", "تم إلغاء عمليه تسجيل الدخول من خلالكم",
                        "fas fa-times");
                }
            }, {
                scope: 'email'
            });
        }

        // Fetch the user profile data from facebook
        function getFbUserData() {
            FB.api('/me', {
                    locale: 'en_US',
                    fields: 'id,first_name,last_name,email,link,gender,locale,picture'
                },
                function(response) {
                    saveUserData(response);
                });
        }

        // Save user data to the database
        function saveUserData(userData) {
            $.ajax({
                url: "{{ route('site.login.facebook', ['provider' => 'facebook']) }}",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: userData,
                dataType: 'json',
                method: 'post',
                success: function(response) {
                    notification("success", response, "fas fa-check");
                    window.location.reload();
                }
            });
        }
    </script>
@endpush
