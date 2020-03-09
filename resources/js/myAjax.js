
    $.ajax({
        url : '/videosAjaxCreate',
        type : 'POST',
        data_type : 'json',
        success: function(data){
            console.log(data);
        }
    });
