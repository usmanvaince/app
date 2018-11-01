<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-77737343-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-77737343-2');
</script>
       <?php
/*
---------------------------------------------------------
| © 2018 eSport Event GmbH								|
| E-Mail: info@esport-event.gmbh						|
---------------------------------------------------------
*/
include("functions/functions.php");

require_once "templates/header.php";
?>
<section id="home_head" class="full_width">
        <div class="container clearfix">
        </div>
    </section>
    <section id="home_latest_event" class="full_width event_image_big">
                            <img src="/images/event-backgrounds/hyperx_blue_1650x500.png">
        <div class="container">
            <div class="inner">
                <h2><span>Aktuelles</span> Turnier</h2>
                <div class="delimiter yellow"></div>
                <div class="event_infos">
                    <div class="inner clearfix">
                        <div class="left">
                            <!-- 206x206 -->
                         <img src="/images/logos/wappen_hyperx_cloud_cup_blue_500x500.png" alt="FIFA Turnier">
                        </div>
                        <div class="middle">
                            <p class="event_series">FIFA 19 - Ultimate Team</p>
                            <p class="event_location">HyperX Cloud Cup</p>
                            <p class="event_date"></p>
                            <p class="event_info">☛ 15 FIFA Pro Gamer und Leandro Curty, der Gewinner aus dem Qualifikationsturnier spielen um 1000,- EUR Preisgeld! Alle Spiele werden live auf Petkus eSport TV übertragen! Verpasse kein Spiel und verfolge die Spiele auf Twitch!
                            </p>
						<a class="button yellow" href="/scripts/turnierbereich/index.php?turnier=248&action=tabelle">Spielplan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="home_latest_events">
        <div class="container">
            <h3><span>Nächste</span> Turniere</h3>
            <div class="delimiter yellow"></div>
            <p>Die Teilnehmerzahl bei unseren Turnieren ist limitiert und somit begrenzt.</p>
            <p>Melde dich jetzt für ein Turnier in deiner Stadt oder für ein Online-Turnier an.</p>
        </div>
    </section>
    <section id="home_next_events" class="full_width">
        <div id="start_slider">
            <div class="vw_slider style_1">
                <ul class="slides" slidecount="4">
					<li class="slide" slidenumber="1">
                        <div class="inner">
                            <img src="/images/event-backgrounds/squad_cup_1650x500.png">
                            <div class="slider_content event_infos clearfix">
                                <div class="inner clearfix">
                                    <div class="left">
                                        <img src="/images/logos/squad_cup_500x500.png" alt="FIFA Turnier"
                                    </div>
                                    <div class="middle">
                                        <p class="event_series">Ultimate Team - 1vs1</p>
                                        <p class="event_location">Squad Cup #2</p>
                                        <p class="event_date">01.11.2018</p>
                                        <p class="event_info">☛ Teste dein Team für die Weekend League und beweise dein Können beim Squad Cup! Ein Preispool von 500,- € wartet auf die drei Besten Spieler und das alle 2 Wochen! Melde dich jetzt an und trainiere mit deinem Team!
                                        </p>
                            			<a class="button yellow" href="/ticketshops/de/">Jetzt anmelden</a>
										 </div>
                                </div>
                            </div>
                        </div>
                    </li>
					<li class="slide" slidenumber="2">
                        <div class="inner">
                            <img src="/images/event-backgrounds/fifa_19_turniere_1650x500.png">
                            <div class="slider_content event_infos clearfix">
                                <div class="inner clearfix">
                                    <div class="left">
                                        <img src="/images/logos/fifa_19_500x500.png" alt="FIFA Turnier"
                                    </div>
                                    <div class="middle">
                                        <p class="event_series">FIFA Turnier - 2vs2</p>
                                        <p class="event_location">Regensburg</p>
                                        <p class="event_date">03.11.2018</p>
                                        <p class="event_info">☛ Wir suchen Euch! Werdet das beste FIFA-Team in der Continental Arena in Regensburg und sichert Euch das Preisgeld von 1000,-€.
                                        </p>
                          				<a class="button yellow" href="/ticketshops/de/">Jetzt anmelden</a>
										 </div>
                                </div>
                            </div>
                        </div>
                    </li>
					<li class="slide" slidenumber="3">
                        <div class="inner">
                            <img src="/images/event-backgrounds/fifa_19_turniere_1650x500.png">
                            <div class="slider_content event_infos clearfix">
                                <div class="inner clearfix">
                                    <div class="left">
                                        <img src="/images/logos/fifa_19_500x500.png" alt="FIFA Turnier"
                                    </div>
                                    <div class="middle">
                                        <p class="event_series">FIFA Turnier - 2vs2</p>
                                        <p class="event_location">Chemnitz</p>
                                        <p class="event_date">03.11.2018</p>
                                        <p class="event_info">☛ Wir suchen Euch! Werdet das beste FIFA-Team in der POWERhall in Chemnitz und sichert Euch das Preisgeld von 1000,-€.
                                        </p>
                          				<a class="button yellow" href="/ticketshops/de/">Jetzt anmelden</a>
										 </div>
                                </div>
                            </div>
                        </div>
                    </li>
					<li class="slide" slidenumber="4">
                        <div class="inner">
                            <img src="/images/event-backgrounds/fifa_19_turniere_1650x500.png">
                            <div class="slider_content event_infos clearfix">
                                <div class="inner clearfix">
                                    <div class="left">
                                        <img src="/images/logos/fifa_19_500x500.png" alt="FIFA Turnier"
                                    </div>
                                    <div class="middle">
                                        <p class="event_series">FIFA Turnier - 2vs2</p>
                                        <p class="event_location">Nürnberg</p>
                                        <p class="event_date">04.11.2018</p>
                                        <p class="event_info">☛ Wir suchen Euch! Werdet das beste FIFA-Team im Cinecitta in Nürnberg und sichert Euch das Preisgeld von 1000,-€.
                                        </p>
                          				<a class="button yellow" href="/ticketshops/de/">Jetzt anmelden</a>
										 </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="slide" slidenumber="5">
                        <div class="inner">
                            <img src="/images/event-backgrounds/fifa_19_turniere_1650x500.png">
                            <div class="slider_content event_infos clearfix">
                                <div class="inner clearfix">
                                    <div class="left">
                                        <img src="/images/logos/fifa_19_500x500.png" alt="FIFA Turnier"
                                    </div>
                                    <div class="middle">
                                        <p class="event_series">FIFA Turnier - 2vs2</p>
                                        <p class="event_location">Erfurt</p>
                                        <p class="event_date">04.11.2018</p>
                                        <p class="event_info">☛ Wir suchen Euch! Werdet das beste FIFA-Team im CineStar in Erfurt und sichert Euch das Preisgeld von 1000,-€.
                                        </p>
                          				<a class="button yellow" href="/ticketshops/de/">Jetzt anmelden</a>
										 </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul class="slider_navigation">
                    <li slidenumber="1" class=""></li>
					<li slidenumber="2" class=""></li>
					<li slidenumber="3" class=""></li>
					<li slidenumber="4" class=""></li>
					<li slidenumber="5" class="active"></li>
                </ul>
                <svg class="previous" viewBox="0 0 30 56" width="30px" height="56px" style="display: none;">
                    <path d="M 29 1.5 L 1 29.5 L 27 55.5 " stroke="#000" stroke-width="1" fill="none"></path>
                </svg>
                <svg class="next" viewBox="0 0 30 56" width="30px" height="56px">
                    <path d="M 1 1.5 L 29 29.5 L 3 55.5 " stroke="#000" stroke-width="1" fill="none"></path>
                </svg>
            </div>
        </div>
    </section>
    <section id="home_older_events" class="grid">
        <div class="container clearfix">
            <h3><span>Beendete</span> Turniere</h3>
            <div class="delimiter yellow"></div>
            <div class="event_container clearfix">
                <?php
                $query = mysqli_query($connection, "SELECT * FROM b_turniere WHERE turniermodus = '2' AND gestartet = '1' AND beendet = '1' ORDER BY turnierstart DESC LIMIT 9");

                while ($db = $query->fetch_object()):

                    $ort = $db->turnierort;
                    $datum = date("d.m.y", $db->turnierstart);
                    $link = "scripts/turnierbereich/index.php?turnier=" . $db->turniere_id . "&action=tabelle";
                    $logo = $db->logo;
                    switch ($logo) {
                        case 'lg':
                            $logo = '/images/logos/virtual-league.png';
                            break;
                        case 'esports':
                            $logo = '/images/logos/esport-cup.png';
                            break;
                        case 'esportsnorton':
                            $logo = '/images/logos/esport-cup-norton.png';
                            break;
                        case 'hyperx':
                            $logo = '/images/logos/hyperx-cloud-cup.png';
                            break;
                        case 'fifa':
                            $logo = '/images/logos/fifa.png';
                            break;
						case 'vblmainz':
                            $logo = '/images/logos/mainz_virtuelle_bundesliga_500x500.png';
                            break;
						case 'h96':
							$logo = '/images/logos/vbl_h96_500x500.png';
							break;
						case 'vflbochum':
							$logo = '/images/logos/wappen_vflbochum_etalentwerk_500x500.png';
							break;
						case 'wirliebenesport':
							$logo = '/images/logos/wirliebensport_online_cup_logo.png';
							break;
						case 'herthabsc':
							$logo = '/images/logos/vorlage_herthabscakademie.png';
							break;
						case 'vflwolfsburg':
							$logo = '/images/logos/vflwolfsburg_eacademy_wappen_500x500.png';
							break;
						case 'fcbasel':
							$logo = '/images/logos/wappen_fcbasel_esports_muba.png';
							break;
						case 'widmann':
							$logo = '/images/logos/mercedes_wappen_500x500.png';
							break;
						case 'widmann':
							$logo = '/images/logos/mercedes_wappen_500x500.png';
							break;
					 	case 'blick':
                            $logo = '/images/logos/500x500blick.png';
                            break;
                   		case 'fifamuseum':
                            $logo = '/images/logos/fifamuseum.png';
                            break; 
						case 'generali':
							$logo = '/images/logos/logo_generali_wm_esport_500px.png';
							break;
						case 'sparkasse':
							$logo = '/images/logos/sparkassencup_500x500.png';
							break;
						case 'squadcup':
							$logo = '/images/logos/squad_cup_500x500.png';
							break;
						case 'hyperxblue':
							$logo = '/images/logos/wappen_hyperx_cloud_cup_blue_500x500.png';
							break;
                    }

                    ?>
                    <div class="old_event">
                        <h4><?php echo $ort; ?></h4>
                        <p class="old_date"><?php echo $datum; ?></p>
                        <img src="<?php echo $logo; ?>">
                        <a class="button white" href="<?php echo $link; ?>">Mehr Infos</a>
                    </div>


                <?php endwhile; ?>

                
                <input type="hidden" value="0" id="offset" />

            </div>
            <div class="center">
                <div id="load_more_events" class="button black">weitere laden</div>
            </div>
    </section>

<?php
require_once "templates/footer.php";
?>