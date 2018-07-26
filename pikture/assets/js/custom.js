jQuery(document).ready(function($) {

      

/*------------------------------------------------
            PRELOADER
------------------------------------------------*/

$('#loader').delay(800).fadeOut();
$('#loader-container').delay(800).fadeOut("slow");

$('.display-none').css({'display' : 'block'});

/*------------------------------------------------
                STICKY HEADER
------------------------------------------------*/

$(window).scroll(function() {    
    var scroll = $(window).scrollTop();  
    if (scroll > 1) {
        $(".sticky-menu .site-header").addClass("nav-shrink");
    }
    else {
         $(".sticky-menu .site-header").removeClass("nav-shrink");
    }
});

/*------------------------------------------------
                BACK TO TOP
------------------------------------------------*/

 $(window).scroll(function(){
    if ($(this).scrollTop() > 1) {
            $('.backtotop').css({bottom:"25px"});
        } 
        else {
            $('.backtotop').css({bottom:"-100px"});
        }
    });

    $('.backtotop').click(function(){
        $('html, body').animate({scrollTop: '0px'}, 800);
        return false;
    });

/*------------------------------------------------
                MENU ACTIVE AND STICKY
------------------------------------------------*/

$("#masthead .menu-toggle").click(function() {    
    $("#masthead").toggleClass("menu-open");
      $('.main-navigation ul.menu').toggle();
});


/*------------------------------------------------
              REsponsive menu click remove
------------------------------------------------*/
$( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) { // ESC
        $(".modern-menu #masthead").removeClass("menu-open");
        $('.modern-menu .main-navigation ul.menu').hide();
        $('.modern-menu .main-navigation').removeClass('toggled-on');

    }
});

$(document).click(function (e) {
      var container = $(".main-navigation");
       if (!container.is(e.target) && container.has(e.target).length === 0) {
            $(".modern-menu #masthead").removeClass("menu-open");
        $('.modern-menu .main-navigation ul.menu').hide();
        $('.modern-menu .main-navigation').removeClass('toggled-on');
         $('.modern-menu #page div').removeClass('menu-overlay');
        }
    });


/*------------------------------------------------
        Menu Overlay Click and Remove
------------------------------------------------*/
    $('.modern-menu .menu-toggle').click(function(){
        $('.main-navigation').toggleClass('menu-open');
        $( '#search' ).slideUp();
        $( 'body' ).removeClass('search-active');
        $( '.search-icons' ).removeClass('search-open');


       if( $('#page div').hasClass('menu-overlay' ) ) {
            $('#page div').removeClass('menu-overlay');
        }
        else {
            $('#page').append('<div class="menu-overlay"></div>');
        }
    });


   $(document).keyup(function(e) {
        if (e.keyCode === 27) {
            $('.main-navigation').removeClass('menu-open');

       if( $('#page div').hasClass('menu-overlay' ) ) {
            $('#page div').removeClass('menu-overlay');
        }
        else {
            $('#page').remove('<div class="menu-overlay"></div>');
        }
        }
    });

  if ($(window).width() < 992) {
    $('body').addClass('modern-menu');
}
  if ($(window).width() < 992) {
    $('body').removeClass('classic-menu');
}
/*------------------------------------------------
                SEARCH
------------------------------------------------*/
$( '.main-navigation .search-icons' ).click(function(event){
    event.preventDefault();
    $( '#search' ).slideToggle();
    $(this).toggleClass('search-open');
    $('body').toggleClass('search-active');
    $('#search input[type="search"]').focus();
    $('.main-navigation').removeClass('toggled-on menu-open');
    $('.modern-menu #masthead').removeClass('menu-open');
    $('.modern-menu .main-navigation #primary-menu').fadeOut();
    $('#page div').removeClass('menu-overlay');

  if ($(window).width() < 992) {
    $('body').addClass('modern-menu');
}

});


$( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) { // ESC
        $( '#masthead #search' ).fadeOut();
        $( 'body' ).removeClass('search-active');
        $( '.search-icons' ).removeClass('search-open');
    }
});

$(document).click(function (e) {
      var container = $(".site-header");
       if (!container.is(e.target) && container.has(e.target).length === 0) {
         $( '#masthead #search' ).fadeOut();
        $( 'body' ).removeClass('search-active');
        $( '.search-icons' ).removeClass('search-open');
    }
    });

/*------------------------------------------------
              DROP-DOWN MENU
------------------------------------------------*/
// $('.main-navigation .menu-item-has-children > a').after('<button class="dropdown-toggle" aria-expanded="false"><span class="screen-reader-text">expand child menu</span></button>');

    $('.main-navigation button.dropdown-toggle').click(function() {
       $(this).toggleClass('active');
      $(this).parent().find('.sub-menu').first().slideToggle();
    });

/*------------------------------------------------
              SLICK-SLIDER
------------------------------------------------*/
$('#client .regular').slick({
     responsive: [
    {
      breakpoint: 992,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 601,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    }
  ]
});

$('#testimonial .regular').slick();

$('#about-slider .regular').slick();



/*------------------------------------------------
              Match-height
------------------------------------------------*/
 $('#featured-section article .featured-image').matchHeight(); 



/*------------------------------------------------
              Counter
------------------------------------------------*/
$('.count').each(function () {
    $(this).prop('Counter',0).animate({
        Counter: $(this).text()
    }, {
        duration: 4000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
});

/*------------------------------------------------
              Packery
------------------------------------------------*/
$('.grid').packery({
  itemSelector: '.grid-item'
});



/*--------------------------------------------------------
                COLOR, BOXED LAYOUT AND FONT SWITCHER
----------------------------------------------------------*/
$('.color-switcher .switch-colors li').click(function(){
    $('.color-switcher .switch-colors li').removeClass('active');
    $(this).addClass('active');
});

$("#green" ).click(function(){
    $("#color" ).attr("href", "assets/css/unminified/green.css");
});

$("#purple" ).click(function(){
    $("#color" ).attr("href", "assets/css/unminified/purple.css");
});

$("#light-blue" ).click(function(){
    $("#color" ).attr("href", "assets/css/unminified/light-blue.css");
});

$("#brown" ).click(function(){
    $("#color" ).attr("href", "assets/css/unminified/brown.css");
});

$("#orange" ).click(function(){
    $("#color" ).attr("href", "assets/css/unminified/orange.css");
});

$("#blue" ).click(function(){
    $("#color" ).attr("href", "assets/css/unminified/blue.css");
});

$(".picker_close").click(function(){  
    $("#choose_color").toggleClass("position");
});

$('.boxed').click(function() {
    $('body').addClass('boxed');
});

$('.wide').click(function() {
    $('body').removeClass('boxed');
    $('body').addClass('wide');
});


$('.font-family li').click(function() {
    $('.font-family li').removeClass('active');
    $(this).addClass('active');
});

$('.header-font-1').click(function() {
    if  ($('body').hasClass('header-font-2') || 
        $('body').hasClass('header-font-3') ||
        $('body').hasClass('header-font-4') || 
        $('body').hasClass('header-font-5'))
    {
        $('body').removeClass('header-font-2 header-font-3 header-font-4 header-font-5');
    }
    $('body').addClass('header-font-1');
});
$('.header-font-2').click(function() {
    if  ($('body').hasClass('header-font-1') || 
        $('body').hasClass('header-font-3') ||
        $('body').hasClass('header-font-4') || 
        $('body').hasClass('header-font-5'))
    {
        $('body').removeClass('header-font-1 header-font-3 header-font-4 header-font-5');
    }
    $('body').addClass('header-font-2');
});
$('.header-font-3').click(function() {
    if  ($('body').hasClass('header-font-1') || 
        $('body').hasClass('header-font-2') ||
        $('body').hasClass('header-font-4') || 
        $('body').hasClass('header-font-5'))
    {
        $('body').removeClass('header-font-1 header-font-2 header-font-4 header-font-5');
    }
    $('body').addClass('header-font-3');
});
$('.header-font-4').click(function() {
    if  ($('body').hasClass('header-font-1') || 
        $('body').hasClass('header-font-2') ||
        $('body').hasClass('header-font-3') || 
        $('body').hasClass('header-font-5'))
    {
        $('body').removeClass('header-font-1 header-font-2 header-font-3 header-font-5');
    }
    $('body').addClass('header-font-4');
});
$('.header-font-5').click(function() {
    if  ($('body').hasClass('header-font-1') || 
        $('body').hasClass('header-font-2') ||
        $('body').hasClass('header-font-3') || 
        $('body').hasClass('header-font-4'))
    {
        $('body').removeClass('header-font-1 header-font-2 header-font-3 header-font-4');
    }
    $('body').addClass('header-font-5');
});

$('.body-font-1').click(function() {
    if  ($('body').hasClass('body-font-2') || 
        $('body').hasClass('body-font-3') ||
        $('body').hasClass('body-font-4') || 
        $('body').hasClass('body-font-5'))
    {
        $('body').removeClass('body-font-1 body-font-2 body-font-3 body-font-4');
    }
    $('body').addClass('body-font-1');
});
$('.body-font-2').click(function() {
    if  ($('body').hasClass('body-font-1') || 
        $('body').hasClass('body-font-3') ||
        $('body').hasClass('body-font-4') || 
        $('body').hasClass('body-font-5'))
    {
        $('body').removeClass('body-font-1 body-font-3 body-font-4 body-font-5');
    }
    $('body').addClass('body-font-2');
});
$('.body-font-3').click(function() {
    if  ($('body').hasClass('body-font-1') || 
        $('body').hasClass('body-font-2') ||
        $('body').hasClass('body-font-4') || 
        $('body').hasClass('body-font-5'))
    {
        $('body').removeClass('body-font-1 body-font-2 body-font-4 body-font-5');
    }
    $('body').addClass('body-font-3');
});
$('.body-font-4').click(function() {
    if  ($('body').hasClass('body-font-1') || 
        $('body').hasClass('body-font-2') ||
        $('body').hasClass('body-font-3') || 
        $('body').hasClass('body-font-5'))
    {
        $('body').removeClass('body-font-1 body-font-2 body-font-3 body-font-5');
    }
    $('body').addClass('body-font-4');
});
$('.body-font-5').click(function() {
    if  ($('body').hasClass('body-font-1') || 
        $('body').hasClass('body-font-2') ||
        $('body').hasClass('body-font-3') || 
        $('body').hasClass('body-font-4'))
    {
        $('body').removeClass('body-font-1 body-font-2 body-font-3 body-font-4');
    }
    $('body').addClass('body-font-5');
});

/*--------------------------------------------------------------------
                END COLOR, BOXED LAYOUT AND FONT SWITCHER
---------------------------------------------------------------------*/









 /*------------------------------------------------
                END JQUERY
------------------------------------------------*/

});