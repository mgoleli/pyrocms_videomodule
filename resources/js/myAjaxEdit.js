$.ajax({
    type: 'UPDATE',
    url: '/videosAjaxUpdate',
    dataType: 'json',
    async: false,
    success: function(data)
    {
        console.log(data);
        //alert(data.message);
    },
    // error: function(e) //
    // {
    //     alert(e.message);
    // }
});