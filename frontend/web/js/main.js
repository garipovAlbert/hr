var slider=[];
$(document).ready(function() {
    $("html").niceScroll({
        'zindex':9999
    });
    $('[data-toggle="btns"] .btn').on('click', function(){
        var $this = $(this);
        if(!$this.is('.active')) {
            $this.parent().find('.active').removeClass('active');
            $this.addClass('active');
        }
    });
    console.log(1);
    $('.owl-carousel').owlCarousel({
        loop:false,
        nav: true,
        navText:['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        margin:0,
        responsiveClass:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1024:{
                items:4
            }
        }
    })
});