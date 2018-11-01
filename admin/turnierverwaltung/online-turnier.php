<?php
$pageKey = 'user_dashboard';

include("../../functions/functions.php");

/*
---------------------------------------------------------
| © 2016 FIFA Turniere // Bayreuther Jungs e.V.				|
| E-Mail: info@fifa-turniere.de							|
---------------------------------------------------------
*/
session_start();

if (!isset($_SESSION["user_id"])):
    header("Location: ../../index.php?info=8");
elseif ($_SESSION["user_status"] != "admin"):
    header("Location: ../../index.php?info=9");
else:

$turniere_id = $_POST['turnier_id'];
$action = $_POST['action'];
$query_turnier = mysqli_query( $connection, "SELECT gestartet FROM b_turniere WHERE turniere_id = '$turniere_id'" );
$db_turnier    = $query_turnier->fetch_object();


$user_query = mysqli_query($connection, "SELECT * FROM fifa_user WHERE user_id = '$teilnehmer_user_id' ");
$db_user = $user_query->fetch_object();



switch($action) {
    case 'anmeldephase_starten' :
        // Status Anmelden in der Datenbank auf 1 ändern
        mysqli_query( $connection, "UPDATE b_turniere SET turnieranmeldung_gestartet = '1' WHERE turniere_id = '$turniere_id'" );
        header("Location: index.php");
        break;
    case 'anmeldephase_beenden' :
        // Status Anmelden in der Datenbank 2 ändern
        mysqli_query( $connection, "UPDATE b_turniere SET turnieranmeldung_gestartet = '2' WHERE turniere_id = '$turniere_id'" );
        header("Location: index.php");
        break;
    case 'checkin_starten' :
        // Status CheckIn in der Datenbank auf 1 ändern
        mysqli_query( $connection, "UPDATE b_turniere SET turniercheckin_gestartet = '1' WHERE turniere_id = '$turniere_id'" );
        header("Location: index.php");
        break;
    case 'checkin_beenden' :
        // Status CheckIn in der Datenbank auf 2 ändern
        mysqli_query( $connection, "UPDATE b_turniere SET turniercheckin_gestartet = '2' WHERE turniere_id = '$turniere_id'" );

        // Alle aus der Anmeldeliste löschen, die nicht eingecheckt sind
        mysqli_query( $connection, "DELETE FROM b_turnieranmeldungen WHERE checked_in = '2' AND turniere_id = '$turniere_id'" );

        header("Location: index.php");
        break;
    case 'checkin2_starten' :
        // Status CheckIn2 in der Datenbank auf 1 ändern
        mysqli_query( $connection, "UPDATE b_turniere SET turniercheckin2_gestartet = '1' WHERE turniere_id = '$turniere_id'" );
        header("Location: index.php");

        break;
    case 'checkin2_beenden' :
        // Status CheckIn2 in der Datenbank auf 2 ändern
        mysqli_query( $connection, "UPDATE b_turniere SET turniercheckin2_gestartet = '2' WHERE turniere_id = '$turniere_id'" );

        $query_selected_turnier = mysqli_query( $connection, "SELECT * FROM b_turniere WHERE turniere_id = '$turniere_id'" );
        $db_selected_turnier    = $query_selected_turnier->fetch_object();
        $plattform = $db_selected_turnier->plattform;

        // Alle aus der Anmeldeliste in die Teilnehmerliste übertragen, die eingecheckt sind
        $query_teilnehmerliste = mysqli_query($connection, "SELECT * FROM b_turnieranmeldungen WHERE turniere_id = '$turniere_id' AND checked_in = '1'");

        //todo: Xbox bzw. PSN-ID in Klammern hiner Spielernamen
        if(mysqli_num_rows($query_teilnehmerliste) > 0) {


            $i = 1;
            while($teilnehmer = $query_teilnehmerliste->fetch_object()) {

                $teilnehmer_user_id = $teilnehmer->user_id;
                $user_query = mysqli_query($connection, "SELECT * FROM fifa_user WHERE user_id = '$teilnehmer_user_id' ");
                $db_user = $user_query->fetch_object();
                $teilnehmer_vorname = $db_user->user_vorname;
                $teilnehmer_nachname = $db_user->user_nachname;


                if($plattform == "ps4") {
                    $user_plattform_id = $db_user->psn_id;
                } elseif ($plattform == "xbox") {
                    $user_plattform_id = $db_user->xbox_id;
                }
                $teilnehmer_user_name = $teilnehmer_vorname . " " . $teilnehmer_nachname . " (" . $user_plattform_id . ")";


                mysqli_query($connection, "UPDATE b_turnierteams SET team = '$teilnehmer_user_name', user_id = '$teilnehmer_user_id' WHERE turniere_id = '$turniere_id' AND team_id = '$i'");
                $i++;
            }

        }
        header("Location: index.php");
        break;
    case 'zeige_in_dashboard' :
        mysqli_query( $connection, "UPDATE b_turniere SET zeige_in_dashboard = '1' WHERE turniere_id = '$turniere_id'" );
        header("Location: index.php");
        break;
    case '' :

        break;
}








endif;








