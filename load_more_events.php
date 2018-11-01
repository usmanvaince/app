<?php

include("functions/functions.php");

$limit = 9;
$offset  = $_POST[offset];
$query   = mysqli_query( $connection, "SELECT * FROM b_turniere WHERE turniermodus = '2' AND gestartet = '1' AND beendet = '1' ORDER BY turnierstart DESC LIMIT $offset,$limit" );

while ( $db = $query->fetch_object() ):

	$ort = $db->turnierort;
	$datum = date( "d.m.y", $db->turnierstart );
	$link  = "scripts/turnierbereich/index.php?turnier=" . $db->turniere_id . "&action=tabelle";
	$logo  = $db->logo;
	switch ( $logo ) {
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

