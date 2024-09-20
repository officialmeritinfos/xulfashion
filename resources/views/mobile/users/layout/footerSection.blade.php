<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(window).on('load', function() {
        $('.loader-wrapper').fadeOut('slow');
    });

    $(window).on('pageshow', function(event) {
        if (event.originalEvent.persisted) {
            // Page is loaded from cache, hide the preloader
            $('.loader-wrapper').fadeOut('slow');
        }
    });

    $('a').on('click', function(e) {
        // Check if the link has the class "back"
        if (!$(this).hasClass('back')) {
            // If it doesn't have the class "back", show the preloader
            $('.loader-wrapper').fadeIn('fast');
        }
    });
    $(window).on('beforeunload', function() {
        $('.loader-wrapper').show();
    });
</script>

<script src="{{asset('sw-register.js')}}"></script>
