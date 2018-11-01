<?php
session_start();
/*
---------------------------------------------------------
| © 2018 eSport Event GmbH			                                       |
| E-Mail: info@esport-event.gmbh					               |
---------------------------------------------------------
*/

include("../../functions/functions.php");

$turniere_id 	= mysqli_real_escape_string($connection,$_GET["turnier"]);
$gruppe 		= mysqli_real_escape_string($connection,$_GET["gruppe"]);

$query_turnier = mysqli_query( $connection, "SELECT * FROM b_turniere WHERE turniere_id = '$turniere_id'" );
$db_turnier    = $query_turnier->fetch_object();

$serie_turnier        = $db_turnier->turniername;
$ort_turnier          = $db_turnier->turnierort;
$spielstaette_turnier = $db_turnier->turnierlocation;
$datum_turnier        = date( "d.m.y", $db_turnier->turnierstart );
$beschreibung_turnier = $db_turnier->turnierbeschreibung;
$link_turniertabelle  = $domain . "scripts/turnierbereich/index.php?turnier=" . $db_turnier->turniere_id . "&action=tabelle";
$link_teilnehmerliste = $domain . "scripts/turnierbereich/index.php?turnier=" . $db_turnier->turniere_id . "&action=teilnehmer";
$link_livestream      = $db_turnier->livestream;
$titelbild			  = $db_turnier->titelbild;

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
		$modus_turnier_link = $domain . '/images/modus/modus_1vs1.png';
		break;
	case '2':
		$modus_turnier_link = $domain . '/images/modus/modus_2vs2.png';
		break;
}

require_once "../../templates/header.php";

?>

    <section id="home_latest_event" class="full_width event_image_big" style="margin-top: 70px;">
        <img src="/images/event-backgrounds/<?php echo $titelbild ?>">
        <div class="container">
            <div class="inner">
                <h2><span>Spielplan</span> Gruppe <?=$gruppe?></h2>
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
                            <a class="button yellow" href="<?php echo $link_turniertabelle ?>">Alle Gruppen</a>
                            <a class="button yellow" href="http://www.twitch.tv/petkus_tv"
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
    <div class="custom_dropDown">
        <button onclick="openDropDown()" class="dropbtn">
            <span>
              Navigation
            </span>
        </button>
        <div id="myDropdown" class="dropdown-content">
            <?php
            if ( getTurniermodusIDVonTurniereID( $turniere_id ) == 1 ) {?>
                <div class="row">
                    <?php
                        for ($i = 1; $i <= countGruppenVonTurniereID($turniere_id); $i++):
                    ?>
                     <div class="col-md-6">
                       <a href="../turniertabelle/index.php?turnier=<?= $turniere_id ?>&gruppe=<?= $i ?>">Gruppe <?= $i ?></a>
                     </div>
                    <?php endfor;?>
                </div>
            <?php }
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
        </>
    </div>
    <section class="content">
        <div class="container">
            <div class="row">


<?php

?>
    <div class="col-md-12 detailseite">
        <div class="box table-responsive">
<?php
			if($db_turnier->online == 1):
?>
            <table class="table table-bordered paarungen shadow_box">
                <tr class="mobile-center">
                    <td>Info</td>
                    <td>HEIM</td>
                    <td>Erg.</td>
                    <td>GAST</td>
                </tr>
                <?php
                $query = mysqli_query($connection,"SELECT turnierspiele_id, spieltag, team_heim, team_gast, tore_heim, tore_gast, spielort, datum FROM b_spiele WHERE turniere_id = '$turniere_id' AND gruppe = '$gruppe' ORDER BY spiele_id ASC");
                while($db = $query->fetch_object()):
                    ?>
                    <tr>
                        <td>
                           # <strong><?=$db->turnierspiele_id?></strong>
                        </td>
                        <td><?=getTurnierteamVonTurnierteamID($turniere_id,$db->team_heim)?></td>
                        <td>
                            <b><?=$db->tore_heim?> : <?=$db->tore_gast?></b>
                            <?=$spielinfo?>
                        </td>
                        <td><?=getTurnierteamVonTurnierteamID($turniere_id,$db->team_gast)?></td>
                    </tr>
                    <?php
                endwhile;
                ?>
            </table>
<?php
			elseif($db_turnier->online == 2):
?>
            <table class="table table-bordered paarungen shadow_box">
                <tr class="mobile-center">
                    <td>Info<br>
                    <td>HEIM</td>
                    <td>Erg.</td>
                    <td>GAST</td>
                </tr>
                <?php
                $query = mysqli_query($connection,"SELECT turnierspiele_id, spieltag, team_heim, team_gast, tore_heim, tore_gast, spielort, datum FROM b_spiele WHERE turniere_id = '$turniere_id' AND gruppe = '$gruppe' ORDER BY spieltag ASC");
                while($db = $query->fetch_object()):
                    ?>
                    <tr>
                        <td>
                            <strong>
                                <?php
                                if(isset($db->datum)):
                                    echo date("H:i", $db->datum);
                                endif;
                                ?>
                            </strong><br>
                            <strong><?=$db->spielort?></strong><br>
                            # <strong><?=$db->turnierspiele_id?></strong>
                        </td>
                        <td><?=getTurnierteamVonTurnierteamID($turniere_id,$db->team_heim)?></td>
                        <td>
                            <b><?=$db->tore_heim?> : <?=$db->tore_gast?></b>
                            <?=$spielinfo?>
                        </td>
                        <td><?=getTurnierteamVonTurnierteamID($turniere_id,$db->team_gast)?></td>
                    </tr>
                    <?php
                endwhile;
                ?>
            </table>
<?php
			endif;
?>
            <table class="table table-bordered kurztabelle detail shadow_box">
                <tr>
                    <td><strong>Pl.</strong></td>
                    <td><b>Team</b></td>
                    <td><b>Sp.</b></td>
                    <td><b>Tore</b></td>
                    <td><b>Diff.</b></td>
                    <td><b>Pkt.</b></td>
                </tr>
                <?php
                $k = 1;
                foreach(getTurniergruppentabelleVonWettbewerbeID($turniere_id,$gruppe) AS $array_wert => $key):
                    ?>
                    <tr>
                        <td><?=$k?>.</td>
                        <td><?=getTurnierteamVonTurnierteamID($turniere_id,$key["teamid"])?></td>
                        <td><?=0+$key["spiele"]?></td>
                        <td><?=0+$key["tore"]?> : <?=0+$key["gegentore"]?></td>
                        <td><?=(0+$key["tore"])-(0+$key["gegentore"])?></td>
                        <td><b><?=0+$key["punkte"]?></b></td>
                    </tr>
                    <?php
                    $k++;
                endforeach;
                ?>
            </table>
            <br>
            <table width="100%" border="0">
                <tbody>

                <tr>
                    <td>&nbsp;</td>
                    <td align="center"><a href	="https://facebook.com/esporteventsdach" target="new"><br>
                            <img src="/images/facebooklike.png" height="60" alt=""/></a></td>
                    <td>&nbsp;</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    </div>
    </section>

<?php
require_once "../../templates/footer.php";
?>