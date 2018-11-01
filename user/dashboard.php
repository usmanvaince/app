<?php
session_start();

if (!isset($_SESSION["user_id"])):
    header("Location: ../../index.php?info=8");
elseif ($_SESSION["user_status"] == "admin"):
    header("Location: ../../index.php?info=9");
else:

$pageKey = 'user_dashboard';
$pageName = 'Dashboard';

include("../functions/functions.php");
require_once "../templates/header.php";

/*
---------------------------------------------------------
| © 2016 FIFA Turniere // Bayreuther Jungs e.V.				|
| E-Mail: info@fifa-turniere.de							|
---------------------------------------------------------
*/


$action = mysqli_real_escape_string($connection,$_GET["action"]);
$id 	= mysqli_real_escape_string($connection,$_GET["id"]);
$query_users = mysqli_query($connection,"SELECT * FROM fifa_user");
$query_profile = mysqli_query($connection,"SELECT * FROM fifa_user WHERE user_id = '".$_SESSION["user_id"]."'");
$db_profile = $query_profile->fetch_object();


// Online Turniere






?>
<div class="wrapper" style="padding-top:70px;">
    <div class="sidebar" style="margin-top:70px;" data-active-color="orange" data-background-color="black" data-image="../templates/assets/img/sidebar-1.jpg">
        <?php require_once "parts/sidebar-user.php"; ?>
    </div>
    <div class="main-panel">
        <?php require_once "parts/header-menu-user-dashboard.php"; ?>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Herzlich willkommen <span><?=$db_profile->user_nick?></span></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        $query_turniere_in_dashboard = mysqli_query($connection, "SELECT * FROM b_turniere WHERE beendet = '2' AND zeige_in_dashboard = '1' ORDER BY turnierstart ASC");
                        while($db = $query_turniere_in_dashboard->fetch_object()) {

                            $turniere_id = $db->turniere_id;
                            $query_turnier = mysqli_query($connection, "SELECT * FROM b_turniere WHERE turniere_id = '" . $turniere_id . "'");
                            $db_turnier = $query_turnier->fetch_object();

	                        $anmeldungs_status = $db_turnier->turnieranmeldung_gestartet;
	                        $checkin_status = $db_turnier->turniercheckin_gestartet;
	                        $checkin2_status = $db_turnier->turniercheckin2_gestartet;
	                        $plattform = $db_turnier->plattform;
	                        $discord = $db_turnier->discord;
							$veranstalter = $db_turnier->veranstalter;

                            $anmeldung_gestartet = false;
                            $anmeldung_beendet = false;
                            $checkin_gestartet = false;
                            $checkin_beendet = false;
                            $checkin2_gestartet = false;
                            $checkin2_beendet = false;

                            if($anmeldungs_status == '1') {
	                            $anmeldung_gestartet = true;
                            }
                            if ($anmeldungs_status == '2') {
                                $anmeldung_beendet = true;
                            }
	                        if($checkin_status == '1') {
		                        $checkin_gestartet = true;
	                        }
	                        if ($checkin_status == '2') {
		                        $checkin_beendet = true;
	                        }
	                        if($checkin2_status == '1') {
		                        $checkin2_gestartet = true;
	                        }
	                        if ($checkin2_status == '2') {
		                        $checkin2_beendet = true;
	                        }

                            // Anmeldeliste des Turniers
                            $query_anmeldeliste = mysqli_query($connection, "SELECT * FROM b_turnieranmeldungen WHERE turniere_id = '" . $turniere_id . "'");
                            $db_anmeldeliste = $query_anmeldeliste->fetch_object();

                            $anzahl_anmeldungen = mysqli_num_rows($query_anmeldeliste);
                            $freie_plaetze = $db_turnier->turnierteilnehmer - $anzahl_anmeldungen;

                            $user_id = $db_profile->user_id;
                            $user_birthday = $db_profile->user_birthday;

                            if($plattform == "ps4") {
                                $user_plattform_id = $db_profile->psn_id;
                            } elseif ($plattform == "xbox") {
                                $user_plattform_id = $db_profile->xbox_id;
                            }

                            $user_bereits_angemeldet = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM b_turnieranmeldungen WHERE turniere_id = '$turniere_id' AND user_id = '$user_id'"));
                            $user_checked_in = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM b_turnieranmeldungen WHERE turniere_id = '$turniere_id' AND user_id = '$user_id' AND checked_in = '1'"));

                            $logo = $db_turnier->logo;
                            switch ($logo) {
                                case 'standard':
                                    $logo = $domain . '/images/logos/fifa.png';
                                    break;
                                case 'herthabsc':
                                    $logo = $domain . '/images/logos/herthabsc_esport_akademie_fifa18_aok_500.png';
                                    break;
                                case '':
                                    $logo = $domain . '';
                                    break;
								case 'hyperxblue':
									$logo = $domain . '/images/logos/wappen_hyperx_cloud_cup_blue_500x500.png';
									break;
							}

                            if ($veranstalter == 'esport_event_gmbh') {
	                            ?>
                                <div class="card dashboard_online_turnier">
                                    <div class="card-header">
                                        <!-- Countdown -->
                                        <input class="turnier_zeit" type="hidden" value="<?= $turniere_id ?>"/>
                                        <div class="row">
                                            <div class="col-md-7">
                                                <h3><?php echo $db_turnier->turniername; ?> </h3>
                                                <p>Turnierstart: <?= date( "d.m.Y - H:i", $db_turnier->turnierstart ) ?>
                                                    Uhr</p>
                                                    Turnierort: <?php echo $db_turnier->turnierort; ?> - <?php echo $db_turnier->turnierlocation; ?>
                                            </div>
                                            <div class="col-md-5">
                                                <div id="clock_<?php echo $turniere_id; ?>"></div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="card-content">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <img src="<?php echo $logo; ?>"/>
                                            </div>
                                            <div class="col-md-5">
                                                <h4><strong>Turnierdaten</strong></h4>
                                                <table class="table table-hover table-responsive">
                                                    <tbody>
                                                    <tr>
                                                        <td><strong>Anzahl Anmeldungen</strong></td>
                                                        <td><?php echo $anzahl_anmeldungen; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Freie Plätze</strong></td>
                                                        <td><?php echo $freie_plaetze; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Beginn Anmeldung</strong></td>
                                                        <td><?= date( "d.m.Y - H:i", $db_turnier->turnieranmeldung ) ?>
                                                            Uhr
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Beginn CheckIn</strong></td>
                                                        <td><?= date( "d.m.Y - H:i", $db_turnier->turniercheckin ) ?>
                                                            Uhr
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Beginn Late CheckIn</strong></td>
                                                        <td><?= date( "d.m.Y - H:i", $db_turnier->turniercheckin2 ) ?>
                                                            Uhr
                                                        </td>
                                                    </tr>
                                                <?php if ( $discord !== NULL ) { ?>
												<tr>
                                                    <td><strong>Discord Channel</strong></td>
                                                    <td><a href="<?php echo $discord; ?>" target="_blank"><img src="/images/sonstiges/discord_join.png"></a></td>
                                                </tr>
                                                <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-5">
                                                <h4><strong>Status</strong></h4>
					                            <?php switch ( $anmeldungs_status ) {
						                            case '0' :
							                            // Anmeldung nicht gestartet
							                            ?>
                                                        <div class="alert alert-info alert-with-icon">
                                                            <i class="material-icons"
                                                               data-notify="icon">info_outline</i>
                                                            <span data-notify="message">Die Anmeldephase für das Turnier hat noch nicht begonnen.</span>
                                                        </div>
							                            <?php
							                            break;
						                            case '1' :
							                            // Anmeldephase gestartet
							                            // Falls genug freie Plätze vorhanden sind & User noch nicht teilnimmt
							                            if ( $freie_plaetze > 0 && $user_bereits_angemeldet == 0 ) {
								                            ?>
                                                            <form method="POST" action="online-turnier.php">
                                                                <input name="action" type="hidden"
                                                                       value="teilnehmen">
                                                                <input name="user_name" type="hidden"
                                                                       value="<?php echo $username; ?>">
                                                                <input name="turnier_id" type="hidden"
                                                                       value="<?php echo $turniere_id ?>">
                                                                <button type="submit" class="btn btn-primary btn-round">
                                                                    Jetzt teilnehmen!
                                                                </button>
                                                            </form>
								                            <?php
							                            } elseif ( $user_bereits_angemeldet > 0 ) {
								                            ?>
                                                            <div class="alert alert-info alert-with-icon">
                                                                <i class="material-icons" data-notify="icon">info_outline</i>
                                                                <span data-notify="message">Du bist für das Turnier angemeldet. Bitte checke dich in das Turnier ein, sobald die Check-In Phase beginnt.<br></span>
                                                            </div>
                                                            <form method="POST" action="online-turnier.php">
                                                                <input name="action" type="hidden"
                                                                       value="abmelden">
                                                                <input name="user_name" type="hidden"
                                                                       value="<?php echo $username; ?>">
                                                                <input name="turnier_id" type="hidden"
                                                                       value="<?php echo $turniere_id ?>">
                                                                <button type="submit" class="btn btn-rose btn-round">
                                                                    Abmelden
                                                                </button>
                                                            </form>
								                            <?php
							                            } elseif ( $freie_plaetze == 0 && $user_bereits_angemeldet == 0 ) {
								                            ?>
                                                            <div class="alert alert-info alert-with-icon">
                                                                <i class="material-icons" data-notify="icon">info_outline</i>
                                                                <span data-notify="message">Es sind leider schon alle Plätze für das Turnier belegt. Falls Sich während der CheckIn-Phase nicht alle Teilnehmer einchecken, hast Du noch die Chance über den Late-Check-In teilzunehmen.</span>
                                                            </div>
								                            <?php
							                            }
							                            break;
						                            case '2' :
							                            // Anmeldephase beendet
							                            ?>

							                            <?php
							                            break;
					                            } ?>
					                            <?php echo '<br>' ?>
					                            <?php switch ( $checkin_status ) {
						                            case '0' :
							                            // CheckIn nicht gestartet
							                            ?>

							                            <?php
							                            break;
						                            case '1' :
							                            // CheckIn gestartet
							                            if ( $user_bereits_angemeldet > 0 && $user_checked_in == 0 ) {

								                            ?>

                                                            <div class="alert alert-info alert-with-icon">
                                                                <i class="material-icons" data-notify="icon">info_outline</i>
                                                                <span data-notify="message">Die Check-In Phase hat begonnen. Bitte checke Dich in das Turnier ein.</span>
                                                            </div>
								                            <?php
                                                            if( !empty( $user_plattform_id ) && $user_birthday == '0000-00-00') {
                                                                // Kein Geburtstag eingetragen
                                                                ?>
                                                                <p>Du hast leider in Deinem Profil noch
                                                                    kein Geburtsdatum hinterlegt.</p>
                                                                <a href="edit-profile.php"
                                                                   class="btn btn-primary btn-round">Profil
                                                                    bearbeiten</a>
	                                                            <?php
                                                            } elseif ( empty( $user_plattform_id ) && $user_birthday == '0000-00-00' ) {
                                                                // Kein Geburtstag und keine Plattform
	                                                            ?>
                                                                <p>Du hast leider in Deinem Profil noch
                                                                    keine <?php if ( $plattform == 'ps4' ) {
			                                                            echo "PSN ID";
		                                                            } else {
			                                                            echo "XBOX Live ID";
		                                                            } ?> hinterlegt. <br>Dein Geburtsdatum ist auch ein Pflichtfeld!</p>
                                                                <a href="edit-profile.php"
                                                                   class="btn btn-primary btn-round">Profil
                                                                    bearbeiten</a>
	                                                            <?php
                                                            } elseif ( empty( $user_plattform_id ) && $user_birthday != '0000-00-00' ) {
                                                                // Keine Plattform
									                            ?>
                                                                <p>Du hast leider in Deinem Profil noch
                                                                    keine <?php if ( $plattform == 'ps4' ) {
											                            echo "PSN ID";
										                            } else {
											                            echo "XBOX Live ID";
										                            } ?> hinterlegt.</p>
                                                                <a href="edit-profile.php"
                                                                   class="btn btn-primary btn-round">Profil
                                                                    bearbeiten</a>
									                            <?php
								                            } else {
									                            ?>
                                                                <form method="POST" action="online-turnier.php">
                                                                    <input name="action" type="hidden"
                                                                           value="einchecken">
                                                                    <input name="user_name" type="hidden"
                                                                           value="<?php echo $username; ?>">
                                                                    <input name="turnier_id" type="hidden"
                                                                           value="<?php echo $turniere_id ?>">
                                                                    <button type="submit"
                                                                            class="btn btn-primary btn-round">
                                                                        Jetzt einchecken!
                                                                    </button>
                                                                </form>
								                            <?php }
							                            } elseif ( $user_bereits_angemeldet > 0 && $user_checked_in > 0 ) {
								                            ?>
                                                            <div class="alert alert-info alert-with-icon">
                                                                <i class="material-icons" data-notify="icon">info_outline</i>
                                                                <span data-notify="message">Du hast Dich erfolgreich in das Turnier eingecheckt.</span>
                                                            </div>
								                            <?php
							                            }
							                            break;
						                            case '2' :
							                            // CheckIn beendet
							                            ?>

							                            <?php
							                            break;
					                            } ?>
					                            <?php echo '<br>'; ?>
					                            <?php switch ( $checkin2_status ) {
						                            case '0' :
							                            // CheckIn2 nicht gestartet
							                            ?>

							                            <?php
							                            break;
						                            case '1' :
							                            // CheckIn2 gestartet
							                            if ( $user_bereits_angemeldet == 0 && $user_checked_in == 0 && $freie_plaetze > 0 ) {
								                            ?>
                                                            <div class="alert alert-info alert-with-icon">
                                                                <i class="material-icons" data-notify="icon">info_outline</i>
                                                                <span data-notify="message">Letzte Chance Dich für das Turnier anzumelden. Die Anmeldung ist verbindlich und kann nicht rückgängig gemacht werden.</span>
                                                            </div>
								                            <?php
								                            if ( empty( $user_plattform_id ) ) {
									                            ?>
                                                                <p>Du hast leider in Deinem Profil noch
                                                                    keine <?php if ( $plattform == 'ps4' ) {
											                            echo "PSN ID";
										                            } else {
											                            echo "XBOX Live ID";
										                            } ?> hinterlegt.</p>
                                                                <a href="edit-profile.php"
                                                                   class="btn btn-primary btn-round">Profil
                                                                    bearbeiten</a>
									                            <?php
								                            } else {
									                            ?>
                                                                <form method="POST" action="online-turnier.php">
                                                                    <input name="action" type="hidden"
                                                                           value="einchecken_und_anmelden">
                                                                    <input name="user_name" type="hidden"
                                                                           value="<?php echo $username; ?>">
                                                                    <input name="turnier_id" type="hidden"
                                                                           value="<?php echo $turniere_id ?>">
                                                                    <button type="submit"
                                                                            class="btn btn-primary btn-round">
                                                                        Anmelden und direkt einchecken!
                                                                    </button>
                                                                </form>
								                            <?php }
							                            } elseif ( $user_bereits_angemeldet == 1 && $user_checked_in == 1 ) {
								                            ?>
                                                            <div class="alert alert-info alert-with-icon">
                                                                <i class="material-icons" data-notify="icon">info_outline</i>
                                                                <span data-notify="message">Du hast dich erfolgreich in das Turnier eingecheckt.</span>
                                                            </div>
								                            <?php
							                            }
							                            break;
						                            case '2' :
							                            // CheckIn2 beendet
							                            if ( $user_bereits_angemeldet == 1 && $user_checked_in == 1 ) {
								                            ?>
                                                            <div class="alert alert-info alert-with-icon">
                                                                <i class="material-icons" data-notify="icon">info_outline</i>
                                                                <button type="button" class="close" data-dismiss="alert"
                                                                        aria-label="Close">x
                                                                </button>
                                                                <span data-notify="message">Du hast dich erfolgreich in das Turnier eingecheckt.</span>
                                                            </div>
								                            <?php
							                            }
							                            break;
					                            } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
	                            <?php
                            } // if hertha_bsc
                        } // while
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header" data-background-color="orange">
                                <i class="material-icons">watch_later</i>
                            </div>
                            <div class="card-content">
                                <p class="category">Mitglied seit</p>
                                <h3 class="card-title"><?=date("d.m.Y", $db_profile->signin)?></h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">account_circle</i>
                                    <a href="<?php echo $domain; ?>user/edit-profile.php">Profil bearbeiten</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header" data-background-color="rose">
                                <i class="material-icons">equalizer</i>
                            </div>
                            <div class="card-content">
                                <p class="category">Gespielte Turniere</p>
                                <?php
                                // Anzahl gespielter Turniere
                                $i = 0;
                                $query = mysqli_query($connection,"SELECT * FROM b_turnierteams INNER JOIN b_turniere ON b_turnierteams.turniere_id = b_turniere.turniere_id WHERE b_turnierteams.team = '$user_name' ORDER BY b_turniere.turniere_id ASC");
                                while($db = $query->fetch_object()) {
                                    $i++;
                                }
                                ?>
                                <h3 class="card-title"><?php echo $i; ?></h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">timeline</i>
                                    <a href="<?php echo $domain; ?>user/statistics.php">Zu meinen Statistiken</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php
        include_once "../templates/footer_dashboard.php";
        ?>
    </div>
</div>



<?php include_once "../templates/scripts.php"; ?>

</body>
</html>


<?php endif; ?>