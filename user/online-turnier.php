<?php
session_start();
if (!isset($_SESSION["user_id"])):
	header("Location: ../../index.php?info=8");
elseif ($_SESSION["user_status"] == "admin"):
	header("Location: ../../index.php?info=9");
else:
$pageKey = 'user_dashboard';
include("../functions/functions.php");
require_once "../templates/header.php";
$turniere_id = $_POST['turnier_id'];
$action = $_POST['action'];
$query_turnier = mysqli_query($connection, "SELECT * FROM b_turniere WHERE turniere_id = '" . $turniere_id . "'");
$db_turnier    = $query_turnier->fetch_object();
$user_id = $_SESSION['user_id'];
$user_query = mysqli_query($connection, "SELECT * FROM fifa_user WHERE user_id = '$user_id' ");
$db_user = $user_query->fetch_object();
$plattform = $db_turnier->plattform;
$username = $db_user->user_nick;
$psn_id = $db_user->psn_id;
$xbox_id = $db_user->xbox_id;
$anzahl_anmeldungen = mysqli_num_rows($query_anmeldeliste);
$freie_plaetze = $db_turnier->turnierteilnehmer - $anzahl_anmeldungen;
// Anmeldeliste des Turniers
$query_anmeldeliste = mysqli_query($connection, "SELECT * FROM b_turnieranmeldungen WHERE turniere_id = '" . $turniere_id . "'");
$db_anmeldeliste = $query_anmeldeliste->fetch_object();
// Prüfen, ob User bereits angemeldet
$user_bereits_angemeldet = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM b_turnieranmeldungen WHERE turniere_id = '$turniere_id' AND user_id = '$user_id'"));
switch($action) {
    case 'teilnehmen' :
        if( $freie_plaetze > 0 && $user_bereits_angemeldet == 0 ) {
            mysqli_query( $connection, "INSERT INTO b_turnieranmeldungen (turniere_id, user_id) VALUES ($turniere_id, $user_id)" );
        }
        header("Location: dashboard.php");
        break;
    case 'abmelden' :
        //
        mysqli_query( $connection, "DELETE FROM b_turnieranmeldungen WHERE turniere_id = '$turniere_id' AND user_id = '$user_id'");
        header("Location: dashboard.php");
        break;
    case 'einchecken' :
        //
        if( $user_bereits_angemeldet  > 0 ) {
            // überprüfen, ob
            mysqli_query( $connection, "UPDATE b_turnieranmeldungen SET checked_in = '1' WHERE turniere_id = '$turniere_id' AND user_id = '$user_id'" );
        }
        header("Location: dashboard.php");
        break;
    case 'einchecken_und_anmelden' :
        //
        if( $user_bereits_angemeldet == 0 && $user_checked_in == 0 && $freie_plaetze > 0) {
            mysqli_query( $connection, "INSERT INTO b_turnieranmeldungen (turniere_id, user_id, checked_in) VALUES ($turniere_id, $user_id, '1')" );
        }
        header("Location: dashboard.php");
        break;
}
endif;
?>