$(document).ready(function () {
    "use strict";

    /* === pre-loader init === */
    $(window).load(function () {
        $('#st-preloader').fadeOut();
        $('.st-preloader-circle').delay(350).fadeOut('slow');
    });
    /* === Search === */
    $('.top-search a').click(function (e) {
        e.preventDefault();
        //when the notification icon is clicked open the menu
        $(this).toggleClass('active');
        $('.show-search').fadeToggle(function () {
            //then bind the close event to html so it closes when you mouse off it.
            $('html').bind('click', function () {
                $('.show-search').fadeOut(function () {
                    //once html has been clicked and the menu has closed, unbind the html click so nothing else has to lag up
                    $('html').unbind('click');
                });
                $('.top-search a').removeClass('active');
            });
            $('.show-search').bind('click', function (e) {

                e.stopPropagation();
            });
        });
    });

    /* === gallery image popup  === */
    $('.img-popup').magnificPopup({
        delegate: 'a',
        type: 'image',
        // other options
        closeOnContentClick: false,
        closeBtnInside: false,
        mainClass: 'mfp-with-zoom mfp-img-mobile',

        gallery: {
            enabled: true
        },
        zoom: {
            enabled: true,
            duration: 300, // don't forget to change the duration also in CSS
            opener: function (element) {
                return element.find('img');
            }
        }

    });
    /* === menu drop-down === */
    if (screen.width > 768) {
        $(".nav.navbar-nav .dropdown").mousemove(function () {
            $(".nav.navbar-nav .dropdown").removeClass("open");
            $(this).addClass("open");
        });
        $(".nav.navbar-nav .dropdown").mouseleave(function () {
            $(".nav.navbar-nav .dropdown").removeClass("open");
        })
    }

    /*--------------------------
     scrollUp
     ---------------------------- */
    $.scrollUp({
        scrollText: '<i class="fa fa-angle-up"></i>',
        easingType: 'linear',
        scrollSpeed: 900,
        animation: 'fade'
    });

});


