$(function() {

    //$(".fancybox").fancybox();

    $(".fancybox").fancybox({
        helpers : {
            overlay : {
                locked : true,
                css : {
                    //'background' : 'rgba(44, 62, 80, 0.90)'
                    'background'    : '#2c3e50'
                    //'opacity'       : '.9'
                }
            }
        },
        padding         : 0
    });


});