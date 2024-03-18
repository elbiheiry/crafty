<script src="{{ asset('site/vendor/jquery.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="{{ asset('site/vendor/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('site/vendor/owl/owl.carousel.js') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script src="{{ asset('site/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('site/vendor/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('site/js/main.js') }}"></script>
<script>
    $(document).on('click', '.add-to-cart', function() {
        var url = $(this).data('url');
        var quantity = $('input[name="quantity"]').val();

        $.ajax({
            url: url,
            method: 'post',
            data: {
                qty: quantity,
                _token: $('input[name="_token"]').val()
            },
            dataType: 'json',
            success: function(response) {
                notification("success", response.message, "fas fa-check");
                $('#cart-count').html(response.counter)
            },
            error: function(jqXHR) {
                var response = $.parseJSON(jqXHR.responseText);
                notification("danger", response, "fas fa-times");
            }
        });
    });
</script>
@stack('js')
