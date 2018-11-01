// Top-Slider
var slideContainer1;
var slide1;
var sliderNavigation1;
var anzahlSlides1;
var slideWidth1;
var slider_is_moving1 = false;
var slideCount1 = 1;
var interval;
var timer;
var imgWidth;

function slideNavigationSetActive1() {
    // function setActive
    $('.vw_slider.style_1 .slider_navigation li').removeClass('active');
    $('.vw_slider.style_1 .slider_navigation li:nth-of-type('+ slideCount1 +')').addClass('active');
}

function TopSliderSlideRight () {
    if(!slider_is_moving1) {
        slider_is_moving1 = true;
        if (slideCount1 < anzahlSlides1) {
            slideContainer1.stop().animate({
                'margin-left': '-=' + slideWidth1 + 'px'
            }, 400, function () {
                // Animation complete.
            });
            slideCount1++;
            slideContainer1.attr('slidecount', slideCount1);
        }
        slideNavigationSetActive1();

        clearInterval(interval);
        timer();

        setTimeout(function () {
            slider_is_moving1 = false;
        }, 450);
    }
}

function TopSliderSlideLeft() {
    if(!slider_is_moving1) {
        slider_is_moving1 = true;
        if (slideCount1 > 1) {
            slideContainer1.stop().animate({
                'margin-left': '+=' + slideWidth1 + 'px'
            }, 400, function () {
                // Animation complete.
            });
            slideCount1--;
            slideContainer1.attr('slidecount', slideCount1);

            //Slides anordnen
            for(var i= anzahlSlides1; i>0; i--){
                $('.vw_slider.style_1 .slide:nth-of-type(' + i + ')').css('margin-left', slideWidth1*(i-1));
            }
        }
        slideNavigationSetActive1();

        clearInterval(interval);
        timer();

        setTimeout(function () {
            slider_is_moving1 = false;
        }, 450);
    }
}

function readyAndResize_1() {

}


function loadAndResize_1() {

    imgWidth = $('.vw_slider.style_1 .slide img').width();

    // HÃ¶he fÃ¼r alle Slider definieren
    if( vpw() > 1000 ) {
        $('.vw_slider.style_1').each(function () {
            var dollarThis = $(this);
            dollarThis.css('height', dollarThis.find('img').height());
        });
    } else if ( vpw() > 767 && vpw() <= 1000) {
        $('.vw_slider.style_1').css('height', '300');
        $('.vw_slider.style_1 .slide .inner > img').css('margin-left', ( vpw() / 2 ) - (imgWidth/2));
    } else {
        $('.vw_slider.style_1').css('height', '450');
        $('.vw_slider.style_1 .slide .inner > img').css('margin-left', ( vpw() / 2 ) - (imgWidth/2));
    }




}


$(window).on('load', function () {

    loadAndResize_1();

    //Slides anordnen
    for(var i= anzahlSlides1; i>0; i--){
        $('.vw_slider.style_1 .slide:nth-of-type(' + i + ')').css('margin-left', slideWidth1*(i-1));
    }


});

var rtime;
var timeout = false;
var delta = 600;
$(window).on('resize', function() {
    rtime = new Date();
    if (timeout === false) {
        timeout = true;
        setTimeout(resizeend, delta);
    }
});

function resizeend() {
    if (new Date() - rtime < delta) {
        setTimeout(resizeend, delta);
    } else {
        timeout = false;
        console.log('resizeEND');
        //Slide bei Resize richtig positionieren
        slideWidth1 = slide1.width();

        //Slides anordnen
        for(var i= anzahlSlides1; i>0; i--){
            $('.vw_slider.style_1 .slide:nth-of-type(' + i + ')').css('margin-left', slideWidth1*(i-1));
        }
        if(slideCount1 > 1) {
            var marginLeft = -(slideCount1-1)*slideWidth1;
            slideContainer1.css('margin-left', marginLeft);
        }
    }
}



$(window).on('resize', function () {

    readyAndResize_1();
    loadAndResize_1();




    clearInterval(interval);
    timer();

});

$(function () {

    readyAndResize_1();

    // Top-Slider
    slideContainer1 = $('.vw_slider.style_1 ul.slides');
    slide1 = $('.vw_slider.style_1 ul.slides li');
    sliderNavigation1 = $('.vw_slider.style_1 ul.slider_navigation');

    // Breite eines Slides
    if( vpw() > 1000 ) {
        slideWidth1 = slide1.width();
    } else {
        slideWidth1 = vpw();
    }

    // Slider-Navigation positionieren
    sliderNavigation1.each(function () {
        $(this).css('margin-left', -($(this).width()/2));
    });

    // Top-Slider Slides + Navigation durchnummerieren
    anzahlSlides1 = $('.vw_slider.style_1 ul.slides li').length;
    for(var i=anzahlSlides1; i>0; i--){
        $('.vw_slider.style_1 .slide:nth-of-type(' + i + ')')
            .attr('slidenumber', i);
        $('.vw_slider.style_1 .slider_navigation li:nth-of-type('+ i +')')
            .attr('slidenumber', i);
    }

    //Slidecount auf 1 setzen
    $('.vw_slider.style_1 ul.slides').attr('slidecount','1');
    $('.vw_slider.style_1 .previous').hide();

    //Slide-Navigation ersten Punkt aktiv setzen
    slideNavigationSetActive1();

    if($('.vw_slider.style_1').length) {
        slideCount1 = slideContainer1.attr('slidecount');
    } else {
        slideCount1 = 0;
    }



    // Auto-slide
    timer = function() {
        interval = setInterval(function(){
            if(!slider_is_moving1) {
                slider_is_moving1 = true;
                if (slideCount1 >= anzahlSlides1) {
                    slideContainer1.stop().animate({
                        'margin-left': '0'
                    }, 400, function () {
                        // Animation complete.
                    });
                    slideCount1 = 1;
                    slideContainer1.attr('slidecount', slideCount1);
                    slideNavigationSetActive1();
                    setTimeout(function () {
                        slider_is_moving1 = false;
                    }, 450);
                } else {
                    slideContainer1.stop().animate({
                        'margin-left': '-=' + slideWidth1 + 'px'
                    }, 400, function () {
                        // Animation complete.
                    });
                    slideCount1++;
                    slideContainer1.attr('slidecount', slideCount1);
                    slideNavigationSetActive1();
                    setTimeout(function () {
                        slider_is_moving1 = false;
                    }, 450);
                }
            }
        }, 8000);
    };

    timer();


    //Slides Swipen
    $('.vw_slider.style_1').on('swipeleft', function () {
        TopSliderSlideRight();
    });
    $('.vw_slider.style_1').on('swiperight', function () {
        TopSliderSlideLeft();
    });

    // Slides Ã¼ber Navigation verschieben
    $('.vw_slider.style_1 .slider_navigation li').on('click', function () {
        if(!slider_is_moving1) {
            slider_is_moving1 = true;
            var dollarThis = $(this);
            var clickedSlidenumber = parseInt(dollarThis.attr('slidenumber'));
            $('.vw_slider.style_1 .previous, .vw_slider.style_1 .next').hide();
            if (clickedSlidenumber < anzahlSlides1) {
                $('.vw_slider.style_1 .next').show();
            }
            if (clickedSlidenumber > 1) {
                $('.vw_slider.style_1 .previous').show();
            }
            slideContainer1.stop().animate({
                'margin-left': '+=' + (slideCount1 - clickedSlidenumber) * slideWidth1 + 'px'
            }, 400, function () {
                // Animation complete.
            });
            slideCount1 = clickedSlidenumber;
            slideNavigationSetActive1();

            clearInterval(interval);
            timer();

            setTimeout(function () {
                slider_is_moving1 = false;
            }, 450);
        }
    });



});

