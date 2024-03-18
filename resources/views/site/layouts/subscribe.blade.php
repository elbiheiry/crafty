<div class="container-fluid newsletters">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-right" data-aos="fade-up" data-aos-delay="40">
                <div class="section_title">
                    <h3>إشترك معنا فى النشرة الإخبارية</h3>
                    <p>
                        إشترك معنا فى النشرة الإخبارية ليصلك كل ماهو جديد من أخبارنا
                    </p>
                </div>
            </div>
            <div class="col-md-6 text-left" data-aos="fade-up" data-aos-delay="80">
                <form class="subscribe-form" method="post" action="{{ route('site.subscribe') }}">
                    @csrf
                    <input type="email" name="email" class="form-control" placeholder=" البريد الألكترونى " />
                    <button class="link" type="submit">
                        <span>اشترك الآن </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $(document).on('submit', '.subscribe-form', function() {
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
                    notification("success", response, "fas fa-check");
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                },
                error: function(jqXHR) {
                    var response = $.parseJSON(jqXHR.responseText);

                    notification("danger", response, "fas fa-times");
                    form.find(":submit").attr('disabled', false).html("<span> اشترك الآن </span>");
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
