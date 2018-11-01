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

    $turniere_id = 246;

    /*$action = $_POST['action'];*/

    // Teilnehmer löschen

    if ( isset( $_POST["submit_teilnehmer_loeschen_bestaetigt"] ) ) {

        $user_id  = mysqli_real_escape_string( $connection, $_POST["loeschen_bestaetigt"] );
        ?>
        <p>Der Teilnehmer mit der ID <strong><?php echo $user_id ?></strong> wurde gelöscht.</p>

        <?php
        mysqli_query( $connection, "DELETE FROM b_turnieranmeldungen WHERE turniere_id = '$turniere_id' AND user_id = '$user_id'");
    }

    if ( isset( $_POST["submit_teilnehmer_loeschen"] ) ) {

        $user_id  = mysqli_real_escape_string( $connection, $_POST["team_id_to_delete"] );
        ?>
        <p>Möchtest Du den Teilnehmer mit der ID <strong><?php echo $user_id ?></strong> wirklich löschen?</p>
        <form method="post" action="">
            <input type="hidden" name="loeschen_bestaetigt"
                   value="<?= $user_id ?>"/>
            <button type="submit" name="submit_teilnehmer_loeschen_bestaetigt"
                    class="btn btn-primary form-control">Teilnehmer wirklich löschen
            </button>
        </form>
        <?php

        //mysqli_query( $connection, "DELETE FROM b_turnieranmeldungen WHERE turniere_id = '$turniere_id' AND user_id = '$user_id'");
    }


    ?>
    <p>Teilnehmer löschen:</p>
    <form method="post" action="">
        <select name="team_id_to_delete" data-size="150" title="wählen">
            <?php
            $query = mysqli_query( $connection, "SELECT user_id FROM b_turnieranmeldungen WHERE turniere_id = '$turniere_id' ORDER BY user_id ASC" );
            while ( $db = $query->fetch_object() ):
                echo "<option value='$db->user_id'>" . $db->user_id . "</option>";
            endwhile;
            ?>
        </select>
        <button type="submit" name="submit_teilnehmer_loeschen"
                class="btn btn-primary form-control">Teilnehmer löschen
        </button>
    </form>
    <?php







    $query_turnier = mysqli_query($connection, "SELECT gestartet FROM b_turniere WHERE turniere_id = '$turniere_id'");

    $db_turnier = $query_turnier->fetch_object();


    $user_query = mysqli_query($connection, "SELECT * FROM fifa_user WHERE user_id = '$teilnehmer_user_id' ");

    $db_user = $user_query->fetch_object();


    // Alle aus der Anmeldeliste in die Teilnehmerliste übertragen, die eingecheckt sind

    $query_teilnehmerliste = mysqli_query($connection, "SELECT * FROM b_turnieranmeldungen WHERE turniere_id = '$turniere_id'" );



    if (mysqli_num_rows($query_teilnehmerliste) > 0) {
?>
        <table>
        <tr>
			<th>User ID</th>
            <th>Username</th>
            <th>PSN ID</th>
            <th>Vorname</th>
            <th>Nachname</th>
            <th>Mailadresse</th>
            <th>Postleitzahl</th>
			<th>Geburtstag</th>
			<th>Handy</th>
        </tr>
            <?php
        while ($teilnehmer = $query_teilnehmerliste->fetch_object()) {


            $teilnehmer_user_id = $teilnehmer->user_id;


            $user_query = mysqli_query($connection, "SELECT * FROM fifa_user WHERE user_id = '$teilnehmer_user_id'");


            $db_user = $user_query->fetch_object();

			$teilnehmer_user_id = $db_user->user_id;

            $teilnehmer_user_name = $db_user->user_nick;

            $teilnehmer_phone = $db_user->user_phone;

            $teilnehmer_user_vorname = $db_user->user_vorname;

            $teilnehmer_user_nachname = $db_user->user_nachname;

            $teilnehmer_user_plz = $db_user->user_zip_code;

            $teilnehmer_user_mail = $db_user->user_email;

            $teilnehmer_user_psn = $db_user->psn_id;
			
			$teilnehmer_user_birthday = $db_user->user_birthday;

            ?>
            <tr>
				<td><?=$teilnehmer_user_id ?></td>
                <td><?=$teilnehmer_user_name ?></td>
                <td><?=$teilnehmer_user_psn ?></td>
                <td><?=$teilnehmer_user_vorname ?></td>
                <td><?=$teilnehmer_user_nachname ?></td>
                <td><?=$teilnehmer_user_mail ?></td>
                <td><?=$teilnehmer_user_plz ?></td>
				<td><?=$teilnehmer_user_birthday ?></td>
				<td><?=$teilnehmer_phone ?></td>
            </tr>


            <?php



        }
?>
        </table>
            <?php








    }

    header("Location: index.php");


endif;
