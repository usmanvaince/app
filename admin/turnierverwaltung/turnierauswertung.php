<?php
$pageKey         = 'user_dashboard';

include( "../../functions/functions.php" );
require_once "../../templates/header.php";

/*
---------------------------------------------------------
| © 2016 FIFA Turniere // Bayreuther Jungs e.V.				|
| E-Mail: info@fifa-turniere.de							|
---------------------------------------------------------
*/
session_start();

if ( ! isset( $_SESSION["user_id"] ) ):
	header( "Location: ../../index.php?info=8" );
elseif ( $_SESSION["user_status"] != "admin" ):
	header( "Location: ../../index.php?info=9" );
else:
	$action = mysqli_real_escape_string( $connection, $_GET["action"] );
	$turniere_id = $_POST['turnier_id'];

	?>
    <div class="wrapper" style="padding-top:70px;">
        <div class="sidebar" style="margin-top:70px;" data-active-color="orange" data-background-color="black"
             data-image="../../templates/assets/img/sidebar-1.jpg">
			<?php require_once "../parts/sidebar-admin.php"; ?>
        </div>
        <div class="main-panel">
			<?php require_once "../parts/header-menu-admin-dashboard.php"; ?>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <?php

                        // Turnierauswertung
                        $query_turnier = mysqli_query($connection, "SELECT * FROM b_turniere WHERE turniere_id = '$turniere_id'");
                        $db_turnier = $query_turnier->fetch_object();
                        $turnierteilnehmer = $db_turnier->turniergruppen * 2;
                        $turnierspielzeit = $db_turnier->turnierspielzeit + 10;

                        if (countOffeneSpieleVonTurniereID($turniere_id) == 0):
                            mysqli_query($connection, "UPDATE b_turniere SET beendet = '1' WHERE turniere_id = '$turniere_id'");
                            mysqli_query($connection, "UPDATE b_turnierteams SET beendet = '1' WHERE turniere_id = '$turniere_id'");
                            mysqli_query($connection, "INSERT INTO b_turniere (turniername, turniermodus, turnierteilnehmer, turnierfelder, turnierspielzeit, turnierstart, turniergruppenphase_id, turnierrunde, gestartet) VALUES ('$db_turnier->turniername', '2', '$turnierteilnehmer', '$db_turnier->turnierfelder', '$turnierspielzeit', '$time', '$turniere_id', '1', '1')");

                            $turniere_id_neu = mysqli_insert_id($connection);

                            ErstelleBracketVonTurniereID($turniere_id_neu);

                            for ($gruppe = 1; $gruppe <= $db_turnier->turniergruppen; $gruppe++):
                                $i = 1;
                                foreach (getTurniergruppentabelleVonWettbewerbeID($turniere_id, $gruppe) AS $array_wert => $key):
                                    mysqli_query($connection, "INSERT INTO b_turniertabelle (turniere_id, team_id, gruppe, platzierung) VALUES ('$turniere_id', '" . $key["teamid"] . "', '$gruppe', '$i')");

                                    $i++;
                                endforeach;
                            endfor;

                            $query = mysqli_query($connection, "SELECT team_id FROM b_turniertabelle WHERE turniere_id = '$turniere_id' AND platzierung = '1' ORDER BY gruppe ASC");
                            while ($db = $query->fetch_object()):
                                $arGruppen1[] = $db->team_id;

                                mysqli_query($connection, "INSERT INTO b_turnierteams (turniere_id, team_id, team, beendet) VALUES ('$turniere_id_neu', '$db->team_id', '" . getTurnierteamVonTurnierteamID($turniere_id, $db->team_id) . "', '2')");
                            endwhile;

                            $query = mysqli_query($connection, "SELECT team_id FROM b_turniertabelle WHERE turniere_id = '$turniere_id' AND platzierung = '2' ORDER BY gruppe DESC");
                            while ($db = $query->fetch_object()):
                                $arGruppen2[] = $db->team_id;

                                mysqli_query($connection, "INSERT INTO b_turnierteams (turniere_id, team_id, team, beendet) VALUES ('$turniere_id_neu', '$db->team_id', '" . getTurnierteamVonTurnierteamID($turniere_id, $db->team_id) . "', '2')");
                            endwhile;

                            $spielnr = 0;
                            $tvnr = 0;

                            $query = mysqli_query($connection, "SELECT * FROM b_spiele WHERE turniere_id = '$turniere_id_neu' AND spieltag = '1' ORDER BY spiele_id ASC");
                            while ($db = $query->fetch_object()):
                                $tvnr++;
                                $spielort = "TV " . $tvnr;

                                if ($spielnr < $db_turnier->turnierfelder):
                                    $datum = $time;
                                else:
                                    if ($spielnr % $db_turnier->turnierfelder == 0):
                                        $datum += (($db_turnier->turnierspielzeit + 10) * 60);
                                    endif;
                                endif;

                                mysqli_query($connection, "UPDATE b_spiele SET team_heim = '" . $arGruppen1[$spielnr] . "', team_gast = '" . $arGruppen2[$spielnr] . "', spielort = '$spielort', datum = '$datum' WHERE spiele_id = '$db->spiele_id'");

                                $spielnr++;

                                if ($tvnr == $db_turnier->turnierfelder):
                                    $tvnr = 0;
                                endif;
                            endwhile;
                        endif;

                        #header("Location: index.php");
                        echo 'Turnier ausgewertet';



                    ?>
                    </div>
                </div>
            </div>
			<?php
			include_once "../../templates/footer_dashboard.php";
			?>
        </div>
    </div>


	<?php include_once "../../templates/scripts.php"; ?>

    </body>
    </html>

<?php endif; ?>