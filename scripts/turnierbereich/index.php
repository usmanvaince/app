<?php
session_start();
/*
---------------------------------------------------------
| © 2016 FIFA Turniere // Bayreuther Jungs e.V.			|
| E-Mail: info@fifa-turniere.de							|
---------------------------------------------------------
*/

include( "../../functions/functions.php" );


$turniere_id = mysqli_real_escape_string( $connection, $_GET["turnier"] );
$action      = mysqli_real_escape_string( $connection, $_GET["action"] );


$query_turnier = mysqli_query( $connection, "SELECT * FROM b_turniere WHERE turniere_id = '$turniere_id'" );
$db_turnier    = $query_turnier->fetch_object();


$serie_turnier        = $db_turnier->turniername;
$ort_turnier          = $db_turnier->turnierort;
$spielstaette_turnier = $db_turnier->turnierlocation;
$datum_turnier        = date( "d.m.Y", $db_turnier->turnierstart );
$beschreibung_turnier = $db_turnier->turnierbeschreibung;
$link_turniertabelle  = $domain . "scripts/turnierbereich/index.php?turnier=" . $db_turnier->turniere_id . "&action=tabelle";
$link_teilnehmerliste = $domain . "scripts/turnierbereich/index.php?turnier=" . $db_turnier->turniere_id . "&action=teilnehmer";
$link_livestream      = $db_turnier->livestream;
$titelbild			  = $db_turnier->titelbild;
$discord 			  = $db_turnier->discord;


$logo_turnier_link = $db_turnier->logo;
switch ( $logo_turnier_link ) {
		case 'lg':
		$logo_turnier_link = $domain . '/images/logos/virtual-league.png';
		break;
	case 'esports':
		$logo_turnier_link = $domain . '/images/logos/esport-cup.png';
		break;
	case 'vblmainz':
		$logo_turnier_link = $domain . '/images/logos/mainz_virtuelle_bundesliga_500x500.png';
		break;
	case 'h96':
		$logo_turnier_link = $domain . '/images/logos/vbl_h96_500x500.png';
		break;
	case 'esportsnorton':
		$logo_turnier_link = $domain . '/images/logos/esport-cup-norton.png';
		break;
	case 'hyperx':
		$logo_turnier_link = $domain . '/images/logos/hyperx-cloud-cup.png';
		break;
	case 'fifa':
		$logo_turnier_link = $domain . '/images/logos/fifa.png';
		break;
	case 'standard':
		$logo_turnier_link = $domain . '/images/logos/standard.png';
		break;
	case 'vflbochum':
		$logo_turnier_link = $domain . '/images/logos/wappen_vflbochum_etalentwerk_500x500.png';
		break;
	case 'wirliebenesport':
		$logo_turnier_link = $domain . '/images/logos/wirliebensport_online_cup_logo.png';
		break;
	case 'herthabsc':
		$logo_turnier_link = $domain . '/images/logos/vorlage_herthabscakademie.png';
		break;
	case 'vflwolfsburg':
		$logo_turnier_link = $domain . '/images/logos/vorlage_VFLwolfsburg.png';
		break;
		case 'fifamuseum':
		$logo_turnier_link = $domain . '/images/logos/fifamuseum.png';
		break;
	case 'fcbasel':
		$logo_turnier_link = $domain . '/images/logos/wappen_fcbasel_esports_muba.png';
		break;
	case 'generali':
		$logo_turnier_link = $domain . '/images/logos/logo_generali_wm_esport_500px.png';
		break;
	case 'sparkasse':
		$logo_turnier_link = $domain . '/images/logos/sparkassencup_500x500.png';
		break;
	case 'squadcup':
		$logo_turnier_link = $domain . '/images/logos/squad_cup_500x500.png';
		break;
	case 'hyperxblue':
		$logo_turnier_link = $domain . '/images/logos/wappen_hyperx_cloud_cup_blue_500x500.png';
		break;
}

$modus_turnier_link = $db_turnier->spielmodus;
switch ( $modus_turnier_link ) {
	case '1':
		$modus_turnier_link = $domain . '/images/modus/modus_1vs1_ps4.png';
		break;
	case '2':
		$modus_turnier_link = $domain . '/images/modus/modus_2vs2_ps4.png';
		break;
	case '3':
		$modus_turnier_link = $domain . '/images/modus/modus_1vs1_xbox.png';
		break;
	case '4':
		$modus_turnier_link = $domain . '/images/modus/modus_2vs2_xbox.png';
		break;
}


if ( $action == "tabelle" ):
	require_once "../../templates/header.php";
	?>
   
    <section id="home_latest_event" class="full_width event_image_big turnierbereich-head" style="margin-top: 70px;">
        <img src="/images/event-backgrounds/<?php echo $titelbild ?>">
        <div class="container">
            <div class="inner">
                <h2><span>Turnier</span>INFO</h2>
                <div class="delimiter yellow"></div>
                <div class="event_infos">
                    <div class="inner clearfix">
                        <div class="left">
                            <!-- 206x206 -->
                            <img src="<?php echo $logo_turnier_link ?>" alt="Logo">
                        </div>
                        <div class="middle">
                            <p class="event_series"><?php echo $serie_turnier ?></p>
                            <p class="event_location"><?php echo $ort_turnier ?>
                                - <?php echo $spielstaette_turnier ?></p>
                            <p class="event_date"><?php echo $datum_turnier ?></p>
                            <p class="event_info"><?php echo $beschreibung_turnier ?></p>
                            <a class="button yellow" href="<?php echo $link_teilnehmerliste ?>">Teilnehmer</a>
                            <?php if ( $discord !== null ) { ?>
                                <a class="button yellow" href="<?php echo $discord; ?>" target="_blank">Discord Channel</a>
                            <?php } ?>
                            <?php if ( $link_livestream !== null ) { ?>
                                <a class="button yellow" href="<?php echo $link_livestream; ?>" target="_blank">Livestream</a>
                            <?php } ?>
                        </div>
                        <div class="right event_mode">
                            <!-- 100x100 -->
                            <img src="<?php echo $modus_turnier_link ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="custom_dropDown">
        <button onclick="openDropDown()" class="dropbtn">
            <span>
              Navigation
            </span>
        </button>
        <div id="myDropdown" class="dropdown-content">
            <?php
            if ( getTurniermodusIDVonTurniereID( $turniere_id ) == 1 ) {
                for ($i = 1; $i <= countGruppenVonTurniereID($turniere_id); $i++):
                    ?>
                    <a href="../turniertabelle/index.php?turnier=<?= $turniere_id ?>&gruppe=<?= $i ?>">Gruppe <?= $i ?></a>
                    <?php
                endfor;
            }
            else if( getTurniermodusIDVonTurniereID( $turniere_id ) == 2 ){ ?>
                <div class="row">
                    <?php
                    for ( $i = 1; $i <= countGruppenVonTurniereID( getTurniergruppenphaseIDVonTurniereID( $turniere_id ) ); $i ++ ): ?>
                        <div class="col-md-6">
                            <a href="../turniertabelle/index.php?turnier=<?= getTurniergruppenphaseIDVonTurniereID( $turniere_id ) ?>&gruppe=<?= $i ?>">Gruppe <?= $i ?>
                            </a>
                        </div>
                    <?php endfor; ?>
                </div>
            <?php } ?>
        </div>
        <img id="caret_up" class="caret_down" src="<?php echo $domain ?>templates/assets/img/caret-down.png">
        <img id="caret_down" class="caret_down" src="<?php echo $domain ?>templates/assets/img/caret-arrow-up.png"
    </div>

    <section class="content">
    <div class="container">
        <?php
        // Gruppenphase
        if ( getTurniermodusIDVonTurniereID( $turniere_id ) == 1 ):
            echo 'usman';
            for ( $i = 1; $i <= countGruppenVonTurniereID( $turniere_id ); $i ++ ):
                ?>
                <?php if ( ( ( $i - 1 ) % 4 ) == 0 && $i > 1 ) { ?></div><?php } ?>
                <?php if ( ( ( $i - 1 ) % 4 ) == 0 ) { ?><div class="row"><?php } ?>
                <div class="col-md-3">
                    <div class="box table-responsive shadow_box">
                        <h2>Gruppe <?= $i ?></h2><a class="btn btn-primary"
                                                    href="../turniertabelle/index.php?turnier=<?= $turniere_id ?>&gruppe=<?= $i ?>">mehr
                            Infos</a>
                        <table class="table table-bordered kurztabelle">
                            <tr>
                                <td><strong>Pl.</strong></td>
                                <td><b>Team</b></td>
                                <td><b>Sp.</b></td>
                                <td><b>Pkt.</b></td>
                            </tr>
                            <?php
                            $k = 1;
                            foreach ( getTurniergruppentabelleVonWettbewerbeID( $turniere_id, $i ) AS $array_wert => $key ):
                                ?>
                                <tr>
                                    <td><?= $k ?>.</td>
                                    <td><?= getTurnierteamVonTurnierteamID( $turniere_id, $key["teamid"] ) ?></td>
                                    <td><?= 0 + $key["spiele"] ?></td>
                                    <td><b><?= 0 + $key["punkte"] ?></b></td>
                                </tr>
                                <?php
                                $k ++;
                            endforeach;
                            ?>
                        </table>
                    </div>
                </div>
            <?php
            endfor;

            ?>
            </div>
            </section>
        <?php
        // K.O.-Phase
        elseif ( getTurniermodusIDVonTurniereID( $turniere_id ) == 2 ):
            ### vorherige Gruppenphase ##

            for ( $i = 1; $i <= countGruppenVonTurniereID( getTurniergruppenphaseIDVonTurniereID( $turniere_id ) ); $i ++ ):
                ?>
                <?php if ( ( ( $i - 1 ) % 4 ) == 0 && $i > 1 ) { ?></div><?php } ?>
                <?php if ( ( ( $i - 1 ) % 4 ) == 0 ) { ?><div class="row"><?php } ?>
                <div class="col-md-3">
                    <div class="box table-responsive shadow_box">
                        <h2>Gruppe <?= $i ?></h2><a class="btn btn-primary"
                                                    href="../turniertabelle/index.php?turnier=<?= getTurniergruppenphaseIDVonTurniereID( $turniere_id ) ?>&gruppe=<?= $i ?>">mehr
                            Infos</a>
                        <table class="table table-bordered kurztabelle">
                            <tr>
                                <td><strong>Pl.</strong></td>
                                <td><b>Team</b></td>
                                <td><b>Sp.</b></td>
                                <td><b>Pkt.</b></td>
                            </tr>
                            <?php
                            $k = 1;
                            foreach ( getTurniergruppentabelleVonWettbewerbeID( getTurniergruppenphaseIDVonTurniereID( $turniere_id ), $i ) AS $array_wert => $key ):
                                ?>
                                <tr>
                                    <td><?= $k ?>.</td>
                                    <td><?= getTurnierteamVonTurnierteamID( getTurniergruppenphaseIDVonTurniereID( $turniere_id ), $key["teamid"] ) ?></td>
                                    <td><?= 0 + $key["spiele"] ?></td>
                                    <td><b><?= 0 + $key["punkte"] ?></b></td>
                                </tr>
                                <?php
                                $k ++;
                            endforeach;
                            ?>
                        </table>
                    </div>
                </div>

            <?php
            endfor;

            ?>


            <?php

            ### aktuelle KO-Runde ###
            for ( $i = 1; $i <= getTurnierrundenVonTurniereID( $turniere_id ) + 1; $i ++ ):
                if($db_turnier->online == 1):
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box table-responsive paarungen result-table">
                            <h2><?= getTurnierrundenname( getTurnierrundenteilnehmerVonTurniereID( $turniere_id, $i ), $turniere_id, $i ) ?></h2>
                            <table class="table table-bordered">
                                <tr class="mobile-center">
                                    <td>Info</td>
                                    <td class="align-l p-l-20">Spielpaarung</td>
                                    <td>Erg.</td>
                                </tr>
                                <?php
                                $query = mysqli_query( $connection, "SELECT turnierspiele_id, team_heim, team_gast, tore_heim, tore_gast, spielinfo, spielort, datum FROM b_spiele WHERE turniere_id = '$turniere_id' AND spieltag = '$i' ORDER BY turnierspiele_id ASC" );
                                while ( $db = $query->fetch_object() ):
                                    if ( $db->spielinfo == 1 ):
                                        $spielinfo = "";
                                    elseif ( $db->spielinfo == 2 ):
                                        $spielinfo = "<br><small>(n.V.)</small>";
                                    elseif ( $db->spielinfo == 3 ):
                                        $spielinfo = "<br><small>(n.E.)</small>";
                                    endif;
                                    ?>
                                    <tr>
                                         <td>
                                            # <strong><?= $db->turnierspiele_id ?></strong>
                                        </td>
                                        <td>
                                            <div>
                                                <?= getTurnierteamVonTurnierteamID( $turniere_id, $db->team_heim ) ?>
                                            </div>
                                            <div>
                                                   <?= getTurnierteamVonTurnierteamID( $turniere_id, $db->team_gast ) ?>
                                            </div>
                                        </td>
                                         <td>
                                             <div>
                                                 <b><?= $db->tore_heim ?></b>
                                             </div>
                                             <div>
                                                 <b><?= $db->tore_gast ?></b>
                                             </div>
                                            <?= $spielinfo ?>
                                        </td>

                                    </tr>
                                <?php
                                endwhile;
                                ?>
                            </table>
                        </div>
                    </div>
                </div>

            <?php
                elseif($db_turnier->online == 2):
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box table-responsive paarungen  result-table">
                            <h2><?= getTurnierrundenname( getTurnierrundenteilnehmerVonTurniereID( $turniere_id, $i ), $turniere_id, $i ) ?></h2>
                            <table class="table table-bordered">
                                <tr class="mobile-center">
                                    <td>Info</td>
                                    <td class="align-l p-l-20">Spielpaarung</td>
                                    <td>Erg.</td>
                                </tr>
                                <?php
                                $query = mysqli_query( $connection, "SELECT turnierspiele_id, team_heim, team_gast, tore_heim, tore_gast, spielinfo, spielort, datum FROM b_spiele WHERE turniere_id = '$turniere_id' AND spieltag = '$i' ORDER BY turnierspiele_id ASC" );
                                while ( $db = $query->fetch_object() ):
                                    if ( $db->spielinfo == 1 ):
                                        $spielinfo = "";
                                    elseif ( $db->spielinfo == 2 ):
                                        $spielinfo = "<br><small>(n.V.)</small>";
                                    elseif ( $db->spielinfo == 3 ):
                                        $spielinfo = "<br><small>(n.E.)</small>";
                                    endif;
                                    ?>
                                    <tr>
                                        <td>
                                            <strong>
                                                <?php
                                                if ( isset( $db->datum ) ):
                                                    echo date( "H:i", $db->datum );
                                                endif;
                                                ?>
                                            </strong><br>
                                            <strong><?= $db->spielort ?></strong><br>
                                            # <strong><?= $db->turnierspiele_id ?></strong>
                                        </td>

                                        <td class="align-l p-l-20">
                                            <div>
                                                <?= getTurnierteamVonTurnierteamID( $turniere_id, $db->team_heim ) ?>
                                            </div>
                                            <div>
                                                <?= getTurnierteamVonTurnierteamID( $turniere_id, $db->team_gast ) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <b><?= $db->tore_heim ?></b>
                                            </div>
                                            <div>
                                                <b><?= $db->tore_gast ?></b>
                                            </div>

                                        </td>
                                    </tr>
                                <?php
                                endwhile;
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            <?php
                endif;
            endfor;

            ### Spiel um Platz 3 ###
            $query_s3 = mysqli_query( $connection, "SELECT team_heim, team_gast, tore_heim, tore_gast FROM b_spiele WHERE turniere_id = '$turniere_id' AND spieltag = '" . getTurnierrundenVonTurniereID( $turniere_id ) . "'" );
            $db_s3    = $query_s3->fetch_object();

            if ( $db_s3->tore_heim > $db_s3->tore_gast ):
                $platz3 = $db_s3->team_heim;
            elseif ( $db_s3->tore_heim < $db_s3->tore_gast ):
                $platz3 = $db_s3->team_gast;
            else:
                $platz3 = "";
            endif;

            ### Finale ###
            $query_finale = mysqli_query( $connection, "SELECT team_heim, team_gast, tore_heim, tore_gast FROM b_spiele WHERE turniere_id = '$turniere_id' AND spieltag = '" . ( getTurnierrundenVonTurniereID( $turniere_id ) + 1 ) . "'" );
            $db_finale    = $query_finale->fetch_object();

            if ( $db_finale->tore_heim > $db_finale->tore_gast ):
                $platz1 = $db_finale->team_heim;
                $platz2 = $db_finale->team_gast;
            elseif ( $db_finale->tore_heim < $db_finale->tore_gast ):
                $platz1 = $db_finale->team_gast;
                $platz2 = $db_finale->team_heim;
            else:
                $platz1 = "";
                $platz2 = "";
            endif;
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="box table-responsive shadow_box siegertreppchen--wrap">
                        <h2>Sieger</h2>
                        <table class="table table-bordered siegertreppchen">
                            <tr>
                                <td><i class="fa fa-trophy" aria-hidden="true"></i> <b>2. Platz</b><br><b><?= getTurnierteamVonTurnierteamID( $turniere_id, $platz2 ) ?></b>
                                </td>
                                <td><i class="fa fa-trophy" aria-hidden="true"></i> <b>1. Platz</b><br><b><?= getTurnierteamVonTurnierteamID( $turniere_id, $platz1 ) ?></b>
                                </td>
                                <td><i class="fa fa-trophy" aria-hidden="true"></i> <b>3. Platz</b><br><b><?= getTurnierteamVonTurnierteamID( $turniere_id, $platz3 ) ?></b></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>

	<?php
	endif;

	require_once "../../templates/footer.php";
elseif ( $action == "teilnehmer" ):
	$teilnehmer = getTurnierteilnehmerVonTurniereID( $turniere_id ) / 8;

	$i     = 1;
	$query = mysqli_query( $connection, "SELECT team_id FROM b_turnierteams WHERE turniere_id = '$turniere_id' AND team NOT LIKE 'Team %' ORDER BY team_id ASC" );
	while ( $db = $query->fetch_object() ):
		if ( $i <= $teilnehmer ):
			$arTeilnehmer1[] = $db->team_id;
        elseif ( $i > $teilnehmer && $i <= ( $teilnehmer * 2 ) ):
			$arTeilnehmer2[] = $db->team_id;
        elseif ( $i > ( $teilnehmer * 2 ) && $i <= ( $teilnehmer * 3 ) ):
			$arTeilnehmer3[] = $db->team_id;
        elseif ( $i > ( $teilnehmer * 3 ) && $i <= ( $teilnehmer * 4 ) ):
			$arTeilnehmer4[] = $db->team_id;
        elseif ( $i > ( $teilnehmer * 4 ) && $i <= ( $teilnehmer * 5 ) ):
			$arTeilnehmer5[] = $db->team_id;
        elseif ( $i > ( $teilnehmer * 5 ) && $i <= ( $teilnehmer * 6 ) ):
			$arTeilnehmer6[] = $db->team_id;
        elseif ( $i > ( $teilnehmer * 6 ) && $i <= ( $teilnehmer * 7 ) ):
			$arTeilnehmer7[] = $db->team_id;
        elseif ( $i > ( $teilnehmer * 7 ) && $i <= ( $teilnehmer * 8 ) ):
			$arTeilnehmer8[] = $db->team_id;
		endif;

		$i ++;
	endwhile;

	require_once "../../templates/header.php";
	?>
    <section id="home_latest_event" class="full_width event_image_big turnierbereich-head" style="margin-top: 110px;">
        <img src="/images/event-backgrounds/<?php echo $titelbild ?>">
        <div class="container">
            <div class="inner">
                <h2><span>Turnier</span>Teilnehmer</h2>
                <div class="delimiter yellow"></div>
                <div class="event_infos">
                    <div class="inner clearfix">
                        <div class="left">
                            <!-- 206x206 -->
                            <img src="<?php echo $logo_turnier_link ?>" alt="Cloud Cup">
                        </div>
                        <div class="middle">
                            <p class="event_series"><?php echo $serie_turnier ?></p>
                            <p class="event_location"><?php echo $ort_turnier ?>
                                - <?php echo $spielstaette_turnier ?></p>
                            <p class="event_date"><?php echo $datum_turnier ?></p>
                            <p class="event_info"><?php echo $beschreibung_turnier ?></p>
                            <a class="button yellow" href="<?php echo $link_turniertabelle ?>">Spielplan</a>
                            <a class="button yellow" href="<?php echo $link_livestream ?>"
                               target="_blank">Livestream</a>
                        </div>
                        <div class="right event_mode">
                            <!-- 100x100 -->
                            <img src="<?php echo $modus_turnier_link ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content group_content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="box table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td><b>ID</b></td>
                                <td><b>Team</b></td>
                            </tr>
							<?php
							$i = 1;
							foreach ( $arTeilnehmer1 AS $team_id ):
								?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= getTurnierteamVonTurnierteamID( $turniere_id, $team_id ) ?></td>
                                </tr>
								<?php
								$i ++;
							endforeach;
							?>
                        </table>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="box table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td><b>ID</b></td>
                                <td><b>Team</b></td>
                            </tr>
							<?php
							$i = 1 + $teilnehmer;
							foreach ( $arTeilnehmer2 AS $team_id ):
								?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= getTurnierteamVonTurnierteamID( $turniere_id, $team_id ) ?></td>
                                </tr>
								<?php
								$i ++;
							endforeach;
							?>
                        </table>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="box table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td><b>ID</b></td>
                                <td><b>Team</b></td>
                            </tr>
							<?php
							$i = 1 + ( $teilnehmer * 2 );
							foreach ( $arTeilnehmer3 AS $team_id ):
								?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= getTurnierteamVonTurnierteamID( $turniere_id, $team_id ) ?></td>
                                </tr>
								<?php
								$i ++;
							endforeach;
							?>
                        </table>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="box table-responsive">
                      <table class="table table-bordered">
                            <tr>
                                <td><b>ID</b></td>
                                <td><b>Team</b></td>
                            </tr>
							<?php
							$i = 1 + ( $teilnehmer * 3 );
							foreach ( $arTeilnehmer4 AS $team_id ):
								?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= getTurnierteamVonTurnierteamID( $turniere_id, $team_id ) ?></td>
                                </tr>
								<?php
								$i ++;
							endforeach;
							?>
                        </table>
                      <br>
                      <br>
<br>
                    </div>
                </div>
                <tr></tr>
                <div class="col-md-3">
                    <div class="box table-responsive">
                      <table class="table table-bordered">
                          <tr>
                                <td><b>ID</b></td>
                                <td><b>Team</b></td>
                        </tr>
							<?php
							$i = 1 + ( $teilnehmer * 4 );
							foreach ( $arTeilnehmer5 AS $team_id ):
								?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= getTurnierteamVonTurnierteamID( $turniere_id, $team_id ) ?></td>
                                </tr>
								<?php
								$i ++;
							endforeach;
							?>
                      </table>
                  </div>
                </div>
                <div class="col-md-3">
                    <div class="box table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td><b>ID</b></td>
                                <td><b>Team</b></td>
                            </tr>
							<?php
							$i = 1 + ( $teilnehmer * 5 );
							foreach ( $arTeilnehmer6 AS $team_id ):
								?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= getTurnierteamVonTurnierteamID( $turniere_id, $team_id ) ?></td>
                                </tr>
								<?php
								$i ++;
							endforeach;
							?>
                        </table>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="box table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td><b>ID</b></td>
                                <td><b>Team</b></td>
                            </tr>
							<?php
							$i = 1 + ( $teilnehmer * 6 );
							foreach ( $arTeilnehmer7 AS $team_id ):
								?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= getTurnierteamVonTurnierteamID( $turniere_id, $team_id ) ?></td>
                                </tr>
								<?php
								$i ++;
							endforeach;
							?>
                        </table>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="box table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td><b>ID</b></td>
                                <td><b>Team</b></td>
                            </tr>
							<?php
							$i = 1 + ( $teilnehmer * 7 );
							foreach ( $arTeilnehmer8 AS $team_id ):
								?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= getTurnierteamVonTurnierteamID( $turniere_id, $team_id ) ?></td>
                                </tr>
								<?php
								$i ++;
							endforeach;
							?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
	<?php
	require_once "../../templates/footer.php";
elseif($action == "infos"):
	$query = mysqli_query($connection,"SELECT * FROM b_turniere WHERE turniere_id = '$turniere_id'");
	$db = $query->fetch_object();

	require_once "../../templates/header.php";
?>
	<section id="home_latest_event" class="full_width event_image_big turnierbereich-head" style="margin-top: 110px;">
        
    </section>
    <section class="content group_content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                	<div class="box table-responsive">
                    	<table class="table table-bordered">
                        	<tr>
                            	<td width="25%" align="center"><b>Registrierung</b></td>
                                <td width="25%" align="center"><b>Check-In</b></td>
                                <td width="25%" align="center"><b>Late Check-In</b></td>
                                <td width="25%" align="center"><b>Turnierstart</b></td>
                            </tr>
                            <tr>
                            	<td align="center"><?=date("d.m.Y - H:i", $db->turnieranmeldung)?> Uhr</td>
                                <td align="center"><?=date("d.m.Y - H:i", $db->turniercheckin)?> Uhr</td>
                                <td align="center"><?=date("d.m.Y - H:i", $db->turniercheckin2)?> Uhr</td>
                                <td align="center"><?=date("d.m.Y - H:i", $db->turnierstart)?> Uhr</td>
                            </tr>
                        </table>
                    </div>
                		<br /><br />
                    <div class="box table-responsive">
                        <table class="table table-bordered">
                        	<tr>
                            	<td width="50%" align="left">Turnierphase</td>
                                <td width="50%" align="right"><?=getTurnierphaseVonTurniereID($turniere_id,$time)?></td>
                            </tr>
                            <tr>
                            	<td align="left">Freie Plätze</td>
                                <td align="right"><?=($db->turnierteilnehmer - countAnmeldungenVonTurniereID($turniere_id))?></td>
                            </tr>
                            <tr>
                            	<td align="left">Check-In's</td>
                                <td align="right"><?=countCheckInsVonTurniereID($turniere_id)?></td>
                            </tr>
                            <tr>
                            	<td align="left">Teilnehmer</td>
                                <td align="right"><?=countAnmeldungenVonTurniereID($turniere_id)?> / <?=$db->turnierteilnehmer?></td>
                            </tr>
                            <tr>
                            	<td align="left">Format</td>
                                <td align="right">
<?php
									if($db->turniermodus == 1):
										echo "Gruppenphase";
									elseif($db->turniermodus == 2):
										echo "KO-Runde";
									endif;
?>
                                </td>
                            </tr>
                            <tr>
                            	<td align="left">Modus</td>
                                <td align="right">
<?php
									if($db->spielmodus == 1):
										echo "1 vs. 1";
									elseif($db->spielmodus == 2):
										echo "2 vs. 2";
									endif;
?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
	require_once "../../templates/footer.php";
elseif($action == "register"):
	$query = mysqli_query($connection,"SELECT * FROM b_turnierteams WHERE turniere_id = '$turniere_id' AND team LIKE '%Team%' ORDER BY team_id ASC LIMIT 1");
	$db = $query->fetch_object();
	
	if(checkUseranmeldungVonTurniereID($turniere_id,$_SESSION["user_fullname"]) == 0):
		mysqli_query($connection,"UPDATE b_turnierteams SET team = '".$_SESSION["user_fullname"]."' WHERE turnierteams_id = '$db->turnierteams_id'");
	endif;
	
	header("Location: ".$domain);
elseif($action == "unregister"):
	$query = mysqli_query($connection,"SELECT * FROM b_turnierteams WHERE turniere_id = '$turniere_id' AND team = '".$_SESSION["user_fullname"]."'");
	$db = $query->fetch_object();
	
	if(checkUseranmeldungVonTurniereID($turniere_id,$_SESSION["user_fullname"]) == 1):
		mysqli_query($connection,"UPDATE b_turnierteams SET team = 'Team ".$db->team_id."' WHERE turnierteams_id = '$db->turnierteams_id'");
	endif;
	
	header("Location: ".$domain);
elseif($action == "checkin"):
	mysqli_query($connection,"UPDATE b_turnierteams SET confirmed = '1' WHERE turniere_id = '$turniere_id' AND team = '".$_SESSION["user_fullname"]."'");
	
	header("Location: ".$domain);
elseif($action == "checkout"):
	mysqli_query($connection,"UPDATE b_turnierteams SET confirmed = '2' WHERE turniere_id = '$turniere_id' AND team = '".$_SESSION["user_fullname"]."'");
	
	header("Location: ".$domain);
elseif($action == "latecheckin"):
	$query = mysqli_query($connection,"SELECT * FROM b_turnierteams WHERE turniere_id = '$turniere_id' AND confirmed = '2' ORDER BY team_id ASC LIMIT 1");
	$db = $query->fetch_object();
	
	if(checkUseranmeldungVonTurniereID($turniere_id,$_SESSION["user_fullname"]) == 0):
		mysqli_query($connection,"UPDATE b_turnierteams SET team = '".$_SESSION["user_fullname"]."', confirmed = '1' WHERE turnierteams_id = '$db->turnierteams_id'");
	endif;
	
	header("Location: ".$domain);
endif;
?>