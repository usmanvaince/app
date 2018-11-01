
// Content-Slider
var slideContainer;
var slide;
var anzahlSlides;
var slideWidth;
var slideCount = 1;
var slider_is_moving = false;
var content;

function slideNavigationSetActive() {
    $('.vw_slider.style_2 .slider_navigation li').removeClass('active');
    $('.vw_slider.style_2 .slider_navigation li:nth-of-type('+ slideCount +')').addClass('active');
}

function slideRight() {
    if (!slider_is_moving) {
        slider_is_moving = true;
        $('.vw_slider.style_2 .previous').show();
        if (slideCount < anzahlSlides) {
            slideContainer.stop().animate({
                'margin-left': '-=' + slideWidth + 'px'
            }, 400, function () {
                // Animation complete.
            });
            slideCount++;
            slideContainer.attr('slidecount', slideCount);
            if (parseInt(slideCount) == anzahlSlides) {
                $('.vw_slider.style_2 .next').hide();
            }

        }
        slideNavigationSetActive();

        setTimeout(function () {
            slider_is_moving = false;
        }, 450);
    }
}

function slideLeft() {
    if (!slider_is_moving) {
        slider_is_moving = true;
        $('.vw_slider.style_2 .next').show();
        if (slideCount > 1) {
            slideContainer.stop().animate({
                'margin-left': '+=' + slideWidth + 'px'
            }, 400, function () {
                // Animation complete.
            });
            slideCount--;
            slideContainer.attr('slidecount', slideCount);
            if (slideCount == 1) {
                $('.vw_slider.style_2 .previous').hide();
            }
        }
        slideNavigationSetActive();

        setTimeout(function () {
            slider_is_moving = false;
        }, 450);
    }
}



function loadAndResize() {

    // HÃ¶he fÃ¼r alle Slider definieren
    $('.vw_slider.style_2').each(function () {
        var dollarThis = $(this);
        dollarThis.css('height', dollarThis.find('img').height());
    });



    if(vpw() < 560) {
        $('.vw_slider.style_2').css('height', 300);
    }



    if ($('.vw_slider.style_2').length) {
        slideCount = slideContainer.attr('slidecount');
    } else {
        slideCount = 0;
    }

    //Content anordnern
    content = $('.vw_slider.style_2 .slider_content');
    content.each(function () {
        var $this = $(this);
        $this.css({
            'width': slideWidth / 2,
            'height': slide.height()
        });
        if(vpw() < 750 && vpw() > 640){
            $this.css('width', slideWidth * 0.6);
        }
        if(vpw() <= 640){
            $this.css('width', slideWidth);
        }
        $this.css('padding-top', (slide.height() - $this.find('.inner').height()) / 2);
        if(vpw() < 560) {
            $this.css('height', 300);
            $this.css('padding-top', (300 - $this.find('.inner').height()) / 2);
        }
    });

    //Slides anordnen
    for (var i = anzahlSlides; i > 0; i--) {
        $('.vw_slider.style_2 .slide:nth-of-type(' + i + ')').css('margin-left', slideWidth * (i - 1));
    }

    //Slide-Navigation ersten Punkt aktiv setzen
    slideNavigationSetActive();

    //Slide bei Resize richtig positionieren
    //slideContainer.css('margin-left', '-500px');


    //Slides Swipen
    $('.vw_slider.style_2').on('swipeleft', function () {
        slideRight();
    });
    $('.vw_slider.style_2').on('swiperight', function () {
        slideLeft();
    });

    //Slides verschieben
    $('.vw_slider.style_2 .next').on('click', function () {
        slideRight();
    });
    $('.vw_slider.style_2 .previous').on('click', function () {
        slideLeft();
    });

    if (slideCount > 1) {
        var marginLeft = -(slideCount-1) * slideWidth;
        slideContainer.css('margin-left', marginLeft);
    }

}


$(window).on('load', function () {


    loadAndResize();
    $('#loader').fadeOut(300);



});

$(window).on('resize', function () {

    slideWidth = slide.width();
    if(vpw() < 560) {
        slideWidth = vpw();
    }
    loadAndResize();

});

$(function () {

    // Content-Slider
    slideContainer = $('.vw_slider.style_2 ul.slides');
    slide = $('.vw_slider.style_2 ul.slides li');
    anzahlSlides = slide.length;
    slideWidth = slide.width();
    if(vpw() < 560) {
        slideWidth = vpw();
    }



    $('.vw_slider.style_2 ul.slider_navigation').each(function () {
        $(this).css('margin-left', -($(this).width()/2));
    });


    // Content-Slider Slides + Navigation durchnummerieren
    for(var i=anzahlSlides; i>0; i--){
        $('.vw_slider.style_2 .slide:nth-of-type(' + i + ')')
            .attr('slidenumber', i);
        $('.vw_slider.style_2 .slider_navigation li:nth-of-type('+ i +')')
            .attr('slidenumber', i);

    }
    $('.vw_slider.style_2 ul.slides').attr('slidecount','1');
    $('.vw_slider.style_2 .previous').hide();

    // Slides Ã¼ber Navigation verschieben
    $('.vw_slider.style_2 .slider_navigation li').on('click', function () {
        if (!slider_is_moving) {
            slider_is_moving = true;
            var dollarThis = $(this);
            var clickedSlidenumber = parseInt(dollarThis.attr('slidenumber'));
            $('.vw_slider.style_2 .previous, .vw_slider.style_2 .next').hide();
            if (clickedSlidenumber < anzahlSlides) {
                $('.vw_slider.style_2 .next').show();
            }
            if (clickedSlidenumber > 1) {
                $('.vw_slider.style_2 .previous').show();
            }
            slideContainer.stop().animate({
                'margin-left': '+=' + (slideCount - clickedSlidenumber) * slideWidth + 'px'
            }, 400, function () {
                // Animation complete.
            });
            slideCount = clickedSlidenumber;
            slideContainer.attr('slidecount', slideCount);

            slideNavigationSetActive();

            setTimeout(function () {
                slider_is_moving = false;
            }, 450);
        }
    });


});

