$(document).ready(function () {



        $.ajax({
            type: 'POST',
            url: '/videosAjaxCreate',
            data: $('#addform').serialize(),
            async: false,
            success: function (data) {
                console.log(data);

                //alert(data.message);
            },

        });
    });
