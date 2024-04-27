const experienceRequests = function (){

    //process add experience
    const addExperience = function (){
        //process the form submission
        $('#processAddExperience').submit(function(e) {
            e.preventDefault();
            var baseURL = $('#processAddExperience').attr('action');

            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                url:baseURL,
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                dataType:"json",
                beforeSend:function(){
                    $('.submit').attr('disabled', true);
                    $("#processAddExperience :input").prop("readonly", true);
                    $(".submit").LoadingOverlay("show",{
                        text        : "processing...",
                        size        : "20"
                    });
                },
                success:function(data)
                {
                    if(data.error===true)
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.error(data.data.error);

                        //return to natural stage
                        setTimeout(function(){
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                            $("#processAddExperience :input").prop("readonly", false);
                        }, 3000);
                    }
                    if(data.error === 'ok')
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.info(data.message);

                        setTimeout(function(){
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                            $("#processAddExperience :input").prop("readonly", false);
                            window.location.replace(data.data.redirectTo)
                        }, 5000);
                    }
                },
                error:function (jqXHR, textStatus, errorThrown){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true
                    }
                    toastr.error(jqXHR.responseJSON.data.error);
                    $("#processAddExperience :input").prop("readonly", false);
                    $('.submit').attr('disabled', false);
                    $(".submit").LoadingOverlay("hide");
                },
            });
        });
    }
    //process update experience
    const updateExperience = function (){
        //process the form submission
        $('#updateExperience').submit(function(e) {
            e.preventDefault();
            var baseURL = $('#updateExperience').attr('action');

            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                url:baseURL,
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                dataType:"json",
                beforeSend:function(){
                    $('.submit').attr('disabled', true);
                    $("#updateExperience :input").prop("readonly", true);
                    $(".submit").LoadingOverlay("show",{
                        text        : "processing...",
                        size        : "20"
                    });
                },
                success:function(data)
                {
                    if(data.error===true)
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.error(data.data.error);

                        //return to natural stage
                        setTimeout(function(){
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                            $("#updateExperience :input").prop("readonly", false);
                        }, 3000);
                    }
                    if(data.error === 'ok')
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.info(data.message);

                        setTimeout(function(){
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                            $("#updateExperience :input").prop("readonly", false);
                            window.location.replace(data.data.redirectTo)
                        }, 5000);
                    }
                },
                error:function (jqXHR, textStatus, errorThrown){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true
                    }
                    toastr.error(jqXHR.responseJSON.data.error);
                    $("#updateExperience :input").prop("readonly", false);
                    $('.submit').attr('disabled', false);
                    $(".submit").LoadingOverlay("hide");
                },
            });
        });
    }
    const someDom = function (){
        //Disable date picker if current
        $(function (){
            if($('input[name="current"]').prop('checked') === true){
                $('input[name="dateFinish"]').attr('disable',true);
            }
        });
        $('input[name="current"]').on('click',function (){
            if($('input[name="current"]').prop('checked') === true){
                $('input[name="dateFinish"]').prop('disabled',true);
            }else{
                $('input[name="dateFinish"]').prop('disabled',false);
            }
        });
    }
    //process delete a work experience
    const deleteExperience = function (){
        //process the form submission
        $('#removeExperience').submit(function(e) {
            e.preventDefault();
            var baseURL = $('#removeExperience').attr('action');

            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                url:baseURL,
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                dataType:"json",
                beforeSend:function(){
                    $('.submit').attr('disabled', true);
                    $("#removeExperience :input").prop("readonly", true);
                    $(".submit").LoadingOverlay("show",{
                        text        : "processing...",
                        size        : "20"
                    });
                },
                success:function(data)
                {
                    if(data.error===true)
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.error(data.data.error);

                        //return to natural stage
                        setTimeout(function(){
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                            $("#removeExperience :input").prop("readonly", false);
                        }, 3000);
                    }
                    if(data.error === 'ok')
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.info(data.message);

                        setTimeout(function(){
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                            $("#removeExperience :input").prop("readonly", false);
                            window.location.replace(data.data.redirectTo)
                        }, 5000);
                    }
                },
                error:function (jqXHR, textStatus, errorThrown){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true
                    }
                    toastr.error(jqXHR.responseJSON.data.error);
                    $("#removeExperience :input").prop("readonly", false);
                    $('.submit').attr('disabled', false);
                    $(".submit").LoadingOverlay("hide");
                },
            });
        });
    }
    //process truncate work experiences
    const truncateExperience = function (){
        //process the form submission
        $('#processTruncateExperience').submit(function(e) {
            e.preventDefault();
            var baseURL = $('#processTruncateExperience').attr('action');

            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                url:baseURL,
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                dataType:"json",
                beforeSend:function(){
                    $('.submit').attr('disabled', true);
                    $("#processTruncateExperience :input").prop("readonly", true);
                    $(".submit").LoadingOverlay("show",{
                        text        : "processing...",
                        size        : "20"
                    });
                },
                success:function(data)
                {
                    if(data.error===true)
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.error(data.data.error);

                        //return to natural stage
                        setTimeout(function(){
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                            $("#processTruncateExperience :input").prop("readonly", false);
                        }, 3000);
                    }
                    if(data.error === 'ok')
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.info(data.message);

                        setTimeout(function(){
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                            $("#processTruncateExperience :input").prop("readonly", false);
                            window.location.replace(data.data.redirectTo)
                        }, 5000);
                    }
                },
                error:function (jqXHR, textStatus, errorThrown){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true
                    }
                    toastr.error(jqXHR.responseJSON.data.error);
                    $("#processTruncateExperience :input").prop("readonly", false);
                    $('.submit').attr('disabled', false);
                    $(".submit").LoadingOverlay("hide");
                },
            });
        });
    }
    const experienceDom = function (){
        $('#deleteExperience').on('show.bs.modal', function(event){
            const button = event.relatedTarget;

            const id = button.getAttribute('data-value');
            const title = button.getAttribute('data-title');
            $('input[name="id"]').val(id);
            $('.modal-title').html('Delete Work Experience: '+title);

        });
        $('#editExperience').on('show.bs.modal', function(event){
            const button = event.relatedTarget;

            const id = button.getAttribute('data-value');
            const title = button.getAttribute('data-title');
            const employer = button.getAttribute('data-employer');
            const address = button.getAttribute('data-address');
            const description = button.getAttribute('data-description');
            const link = button.getAttribute('data-link');
            const start = button.getAttribute('data-start');
            const finish = button.getAttribute('data-finish');


            $('input[name="id"]').val(id);
            $('input[name="title"]').val(title);
            $('input[name="employer"]').val(employer);
            $('input[name="location"]').val(address);
            $('textarea[name="description"]').val(description);
            $('input[name="link"]').val(link);
            $('input[name="dateStart"]').val(start);
            $('input[name="dateFinish"]').val(finish);
            $('.modal-title-update').html('Update Experience: '+title);


            $('textarea[name="description"]').summernote({height: 150});
        });
    }

    return {
        init: function() {
            addExperience();
            updateExperience();
            someDom();
            deleteExperience();
            truncateExperience();
            experienceDom();
        }
    };
}();

jQuery(document).ready(function() {
    experienceRequests.init();
});
