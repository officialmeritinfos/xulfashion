<!-- Notifications js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
<script src="https://kit.fontawesome.com/6b3c5ea29e.js" crossorigin="anonymous"></script>
<script src="{{asset('dashboard/vendors/lightboxed/lightboxed.js')}}"></script>
@include('noti_js')

<script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.11/dist/clipboard.min.js"></script>

<script>
    new ClipboardJS('.copy');
</script>
<script>
    var clipboard= new ClipboardJS('.cpy');
    clipboard.on('success', function(e) {
        toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
        toastr.info("Copied");

    });
</script>
<script>
    var clipboard= new ClipboardJS('.cpy-link');
    clipboard.on('success', function(e) {
        toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
        toastr.info("Link copied. Visit your browser and paste it to continue.");

    });
</script>

<script src="{{asset('dashboard/js/selectize.min.js')}}"></script>
<script>
    $('.selectize').selectize();
    $('.selectizeAdd').selectize({
        create:true,
        showAddOptionOnCreate:true,
        createOnBlur:true,
        highlight:true,
        hideSelected:true
    });
</script>
<script>
    $(document).ready(function(){
        $(".search").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".searches tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

<script src="{{asset('dashboard/vendors/summernote/summernote-bs5.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 150,
        });
    });
</script>

