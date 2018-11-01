var $homeLeft = $('#home_head .left');
var $homeLastestEvent = $('#home_latest_event');
var $startSliderContent = $('#start_slider .event_infos');

var containerMargin;

(function ($, root, undefined) {

    function readyAndResize() {

        // Berechnet den Abstand des Containers nach Links
        containerMargin = parseInt($('#home_older_events > .container').css('margin-left')) + 15;

        $homeLeft.css('padding-left', containerMargin);
        $homeLastestEvent.find('.container').css('margin-left', containerMargin);
        if (vpw() > 767) {
            $startSliderContent.css('margin-left', containerMargin);
        } else {
            $startSliderContent.css('margin-left', '0');
        }

        setEqualHeightForRows($('#home_older_events .old_event h4'), 3);

    };

    function loadAndResize() {

        var img = $('#home_head .right img');
        var imgHeight = img.height();
        var headHeight = $('#home_head .left').height() + 50;

        // Startseite Head anpassen
        if (imgHeight < headHeight && vpw() > 767) {
            img.css({
                'height': headHeight,
                'width': 'auto'
            });
        } else {
            img.css({});
        }

        var $homeLatestEventImg = $('#home_latest_event .event_image_big > img');

        // Bild aktuelles Event anpassen
        if (vpw() <= 1000) {
            $homeLatestEventImg.css('margin-left', (vpw() / 2) - ($homeLatestEventImg.width() / 2));
        }

    };


    $(window).on('load', function () {

       $('#material-loader').fadeOut('slow');

        //Startsequenz einblenden
        var i = 1;
        $homeLeft.find('.capture').each(function () {
            var $this = $(this);
            setTimeout(function () {
                $this.fadeTo('slow', 1)
            }, 500 * i);
            i++;
        });
        setTimeout(function () {
            $homeLeft.find('a').fadeTo('slow', 1);
        }, 500 * (i + 1));

        loadAndResize();

    });

    $(window).on('resize', function () {

        readyAndResize();
        loadAndResize();

    });

    $(function () {

        'use strict';

        readyAndResize();




        // Ajax Countdown
        $('input.turnier_zeit').each(function(key, val){
            var id = $(this).val();
            $.ajax({
                type: "GET",
                url: 'https://app.esport-event.de/turnier_countdown_ajax.php?id=' + id,
                success: function (data) {

                    console.log(data.turnierstart);
                    console.log('clock_' + id);

                    var $el = jQuery('#clock_' + id)

                    $el.jCountdown({
                        timeText:data.turnierstart,
                        timeZone:1,
                        style:"slide",
                        color:"black",
                        width:0,
                        textGroupSpace:4,
                        textSpace:0,
                        reflection:false,
                        reflectionOpacity:10,
                        reflectionBlur:0,
                        dayTextNumber:2,
                        displayDay:true,
                        displayHour:true,
                        displayMinute:true,
                        displaySecond:true,
                        displayLabel:true,
                        onFinish:function(){
                            $el.hide();
                        }
                    });

                    $el.find('.day').append('<label>Tage</label>');
                    $el.find('.hour').append('<label>Stunden</label>');
                    $el.find('.minute').append('<label>Minuten</label>');
                    $el.find('.second').append('<label>Sekunden</label>');

                }
            });
        });






        $(window).on('scroll', function () {
            if ($(this).scrollTop() > 1) {
                $('.header').addClass('sticky');
            } else {
                $('.header').removeClass('sticky');
            }
        });

        //Ajax alte Events laden
        $loader.on( 'click', load_ajax_posts );


        //Dropdown Admin Panel
        $('#open_admin_panel').on('click', function() {
            $(this).next('.dropdown_menu').slideToggle();
        });

        //Datepicker
        $('.datetimepicker').datetimepicker({
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove'
            }

        });

        $('.datepicker').datetimepicker({
            format: 'DD.MM.YYYY',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove'
            }
        });

        $('.timepicker').datetimepicker({
            //          format: 'H:mm',    // use this format if you want the 24hours timepicker
            format: 'h:mm A', //use this format if you want the 12hours timpiecker with AM/PM toggle
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove'
            }
        });

        $('input').each(function(){
            var text_value=$(this).val();
            if(text_value!='')
            {
                $(this).parent('.form-group').removeClass('is-empty');
            }

        })

        // Login Passwort vergessen switchen
        var $loginOpener = $('#open_login');
        var $forgotPwOpener = $('#open_login_forgot_password');
        var $loginBox = $('#login_panel');
        var $forgotPwBox = $('#forgot_password_panel');
        $forgotPwOpener.on('click', function () {
           $loginBox.hide();
           $forgotPwBox.fadeIn('slow');
        });
        $loginOpener.on('click', function () {
            $forgotPwBox.hide();
            $loginBox.fadeIn('slow');
        });


        // Admin-Panel Ergegnisse eintragen Quick-select
        var $quickEditSelectBox = $('#admin--open-games-select-box');
        var $quickEditSelectButton = $('#admin--open-games-select-id');
        var $quickEditPanel = $('#admin--open-games-quick');

        $quickEditSelectButton.on('click', function () {
          var selectedID = $quickEditSelectBox.val();
          $('.wrap--admin-open-games form').each(function () {
             if( $(this).attr('data-game-id') == selectedID) {
                 $quickEditPanel.html($(this).clone());
             }
          });
        });




    });

})(jQuery, this);

var $content = $('#home_older_events .event_container');
var $loader = $('#load_more_events');
var limit = 9;
var offset = $('#home_older_events').find('.old_event').length;

function load_ajax_posts() {
    if (!($loader.hasClass('post_loading_loader') || $loader.hasClass('post_no_more_posts'))) {
        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: 'https://app.esport-event.de/load_more_events.php',
            data: {
                'limit': limit,
                'offset': offset
            },
            beforeSend : function () {
                $loader.addClass('post_loading_loader').css('display', 'none');
            },
            success: function (data) {
                var $data = $(data);
                if ($data.length) {
                    var $newElements = $data.css({ opacity: 0 });
                    $content.append($newElements);
                    setEqualHeightForRows($('#home_older_events .old_event h4'), 3);
                    $newElements.animate({ opacity: 1 });
                    $loader.removeClass('post_loading_loader').css('display', 'inline-block');
                } else {
                    //$loader.removeClass('post_loading_loader').addClass('post_no_more_posts').html('Keine weiteren Beiträge');
                    $loader.css('display', 'none');
                }
            },
            error : function (jqXHR, textStatus, errorThrown) {
                $loader.html($.parseJSON(jqXHR.responseText) + ' :: ' + textStatus + ' :: ' + errorThrown);
                console.log(jqXHR);
            },
        });
    }
    offset += limit;
    return false;
}

function vpw() {
    var viewportwidth;
    if (typeof window.innerWidth != 'undefined') {
        viewportwidth = window.innerWidth
    }
    else if (typeof document.documentElement != 'undefined'
        && typeof document.documentElement.clientWidth !=
        'undefined' && document.documentElement.clientWidth != 0) {
        viewportwidth = document.documentElement.clientWidth
    }
    else {
        viewportwidth = document.getElementsByTagName('body')[0].clientWidth
    }
    return viewportwidth;
}


function setEqualHeightForRows(selection, cols) {
    // Teamseite
    var maxHeight = 0;
    var actHeight = 0;
    // counterLoop zählt immer 4 Elemente durch und wird danach wieder auf 0 gesetzt.
    var counterLoop = 0;
    // counterAfter zählt die erste (Große) Schleifendurchgänge durch.
    var counterAfter = 0;
    // Setzt bei window.resize() die Höhe der Elemente zuerst wieder auf "auto"
    selection.css('height', 'auto');
    //Den 'p-Tag' durchschleifen und jedes Grüppchen (alle 'col-te' Elemente) auf gleiche Höhe setzen
    selection.each(function () {
        counterAfter++;
        // zählt die erste Schleife durch
        if (counterLoop < cols) {
            actHeight = $(this).height();
            if (actHeight > maxHeight) {
                maxHeight = actHeight;
            }
            counterLoop++;
            if (counterLoop >= cols) {
                counterLoop = 0;
                // Zähler für die zweite Schleife
                var count = 0;
                // Bestimmt ab welchem Element die Höhe gesetzt wird
                var counterSelectOnlyThisFourElements = counterAfter - cols;
                // wird nur ausgeführt, wenn die nächste Gruppe durchlaufen ist
                selection.each(function () {
                    // Setzt Höhe nur für die Gruppe
                    if (count >= counterSelectOnlyThisFourElements && count < counterSelectOnlyThisFourElements + cols) {
                        $(this).css("height", maxHeight);
                    }
                    if (count == counterSelectOnlyThisFourElements + cols) {
                        maxHeight = 0;
                    }
                    count++;
                });
            }
        }
    });
}