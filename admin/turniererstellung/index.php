<?php

$pageKey = 'turniererstellung';

$pageName = 'turniererstellung';



include("../../functions/functions.php");

require_once "../../templates/header.php";



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

$action = mysqli_real_escape_string($connection, $_GET["action"]);





?>

<div class="wrapper" style="padding-top:70px;">

    <div class="sidebar" style="margin-top:70px;" data-active-color="orange" data-background-color="black"

         data-image="../../templates/assets/img/sidebar-1.jpg">

		<?php require_once "../parts/sidebar-admin.php"; ?>

    </div>

    <div class="main-panel">

		<?php require_once "../parts/header-menu-admin-dashboard.php"; ?>

        <div class="content <?php echo $pageName; ?>">

            <div class="container-fluid">

                <div class="row">

					<?php



					if(isset($_POST["submit_turniererstellung2"])):

						$turniername 		= mysqli_real_escape_string($connection, $_POST["turniername"]);

						$turnierort 		= mysqli_real_escape_string($connection, $_POST["turnierort"]);

						$turnierlocation 	= mysqli_real_escape_string($connection, $_POST["turnierlocation"]);

						$online 			= mysqli_real_escape_string($connection, $_POST["online"]);

						$spielmodus 		= mysqli_real_escape_string($connection, $_POST["spielmodus"]);

						$turnierteilnehmer 	= mysqli_real_escape_string($connection, $_POST["turnierteilnehmer"]);

						$turniermodus 		= mysqli_real_escape_string($connection, $_POST["turniermodus"]);

						$turniergruppen 	= mysqli_real_escape_string($connection, $_POST["turniergruppen"]);

						$turnierrueckspiel 	= mysqli_real_escape_string($connection, $_POST["turnierrueckspiel"]);

						$turnierfelder 		= mysqli_real_escape_string($connection, $_POST["turnierfelder"]);

						$turnierspielzeit 	= mysqli_real_escape_string($connection, $_POST["turnierspielzeit"]);

						$turnieranmeldung 	= mysqli_real_escape_string($connection, strtotime($_POST["turnieranmeldung"]));

						$turniercheckin 	= mysqli_real_escape_string($connection, strtotime($_POST["turniercheckin"]));

						$turniercheckin2 	= mysqli_real_escape_string($connection, strtotime($_POST["turniercheckin2"]));

						$turnierstart 		= mysqli_real_escape_string($connection, strtotime($_POST["turnierstart"]));

						$titelbild 			= mysqli_real_escape_string($connection, $_POST["titelbild"]);

						$discord 			= mysqli_real_escape_string($connection, $_POST["discord"]);

						$livestream 		= mysqli_real_escape_string($connection, $_POST["livestream"]);

						$logo 				= mysqli_real_escape_string($connection, $_POST["logo"]);



						if($online == 1):

							if($turniermodus == 1):

								mysqli_query($connection, "INSERT INTO b_turniere (turniername, online, spielmodus, turniermodus, turnierteilnehmer, turniergruppen, turnierfelder, turnierspielzeit, turnieranmeldung, turniercheckin, turniercheckin2, turnierstart, rueckspiel_gruppe, logo, livestream, discord, titelbild) VALUES ('$turniername', '$online', '$spielmodus', '$turniermodus', '$turnierteilnehmer', '$turniergruppen', '$turnierfelder', '$turnierspielzeit', '$turnieranmeldung', '$turniercheckin', '$turniercheckin2', '$turnierstart', '$turnierrueckspiel', '$logo', '$livesteam', '$discord', '$titelbild')");

                            elseif($turniermodus == 2):

								mysqli_query($connection, "INSERT INTO b_turniere (turniername, online, spielmodus, turniermodus, turnierteilnehmer, turnierfelder, turnierspielzeit, turnieranmeldung, turniercheckin, turniercheckin2, turnierstart, logo, livestream, discord, titelbild) VALUES ('$turniername', '$online', '$spielmodus', '$turniermodus', '$turnierteilnehmer', '$turnierfelder', '$turnierspielzeit', '$turnieranmeldung', '$turniercheckin', '$turniercheckin2', '$turnierstart', '$logo', '$livesteam', '$discord', '$titelbild')");

							endif;

						else:

							if($turniermodus == 1):

								mysqli_query($connection, "INSERT INTO b_turniere (turniername, turnierort, turnierlocation, online, spielmodus, turniermodus, turnierteilnehmer, turniergruppen, turnierfelder, turnierspielzeit, turnierstart, rueckspiel_gruppe, logo, livestream, discord, titelbild) VALUES ('$turniername', '$turnierort','$turnierlocation', '$online', '$spielmodus', '$turniermodus', '$turnierteilnehmer', '$turniergruppen', '$turnierfelder', '$turnierspielzeit', '$turnierstart', '$turnierrueckspiel', '$logo', '$livesteam', '$discord', '$titelbild')");

                            elseif($turniermodus == 2):

								mysqli_query($connection, "INSERT INTO b_turniere (turniername, turnierort, turnierlocation, online, spielmodus, turniermodus, turnierteilnehmer, turnierfelder, turnierspielzeit, turnierstart, logo, livestream, discord, titelbild) VALUES ('$turniername', '$turnierort','$turnierlocation', '$online', '$spielmodus', '$turniermodus', '$turnierteilnehmer', '$turnierfelder', '$turnierspielzeit', '$turnierstart', '$logo', '$livesteam', '$discord', '$titelbild')");

							endif;

						endif;



						$turniere_id = mysqli_insert_id($connection);



						for($i = 1; $i <= $turnierteilnehmer; $i++):

							$team = "Team " . $i;



							mysqli_query($connection, "INSERT INTO b_turnierteams (turniere_id, team_id, team) VALUES ('$turniere_id', '$i', '$team')");

						endfor;



						header("Location: ".$domain."admin/turnierverwaltung/");

                    elseif(isset($_POST["submit_turniererstellung1"])):

						$turniermodus 	= mysqli_real_escape_string($connection, $_POST["turniermodus"]);

						$online 		= mysqli_real_escape_string($connection, $_POST["online"]);



						require_once "../../templates/header.php";

						?>

                        <div class="col-md-12">

                            <div class="container clearfix">

                                <div class="box table-responsive">

                                    <h2>Turniererstellung</h2>

                                    <form method="POST" action="">

                                        <table class="table table-bordered">

                                            <tr>

                                                <td width="25%" align="left"><b>Turniername:</b></td>

                                                <td width="75%" align="left"><input type="text" name="turniername" class="form-control" required/></td>

                                            </tr>

                                            <tr>

                                                <td width="25%" align="left"><b>Turnierort:</b></td>

                                                <td width="75%" align="left"><input type="text" name="turnierort" class="form-control" required/></td>

                                            </tr>

                                            <tr>

                                                <td width="25%" align="left"><b>Turnierlocation:</b></td>

                                                <td width="75%" align="left"><input type="text" name="turnierlocation" class="form-control" required/></td>

                                            </tr>

                                            <tr>

                                                <td align="left"><b>Spielmodus:</b></td>

                                                <td align="left">

                                                    <select name="spielmodus" size="1" class="form-control">

                                                        <option value="1">1 vs. 1</option>

                                                        <option value="2">2 vs. 2</option>

                                                    </select>

                                                </td>

                                            </tr>

                                            <tr>

                                                <td align="left"><b>max. Teilnehmer:</b></td>

                                                <td align="left">

                                                    <select name="turnierteilnehmer" size="1" class="form-control">

														<?php

														// Gruppenphase

														if($turniermodus == 1):

															echo "<option value='8'>8</option>";

															echo "<option value='16'>16</option>";

															echo "<option value='32'>32</option>";

															echo "<option value='64'>64</option>";

															echo "<option value='80'>80</option>";

															echo "<option value='96'>96</option>";

															echo "<option value='128'>128</option>";

															echo "<option value='192'>192</option>";

															echo "<option value='256'>256</option>";

														//K.O. Runde

                                                        elseif($turniermodus == 2):

															echo "<option value='8'>8</option>";

															echo "<option value='16'>16</option>";

															echo "<option value='32'>32</option>";

															echo "<option value='64'>64</option>";

															echo "<option value='128'>128</option>";

															echo "<option value='256'>256</option>";

															echo "<option value='512'>512</option>";

														endif;

														?>

                                                    </select>

                                                </td>

                                            </tr>

											<?php

											if($turniermodus == 1):

												?>

                                                <tr>

                                                    <td align="left"><b>Anzahl Gruppen:</b></td>

                                                    <td align="left">

                                                        <select name="turniergruppen" size="1" class="form-control">

                                                            <option value="2">2</option>

                                                            <option value="4">4</option>

                                                            <option value="8">8</option>

                                                            <option value="16">16</option>

                                                            <option value="32">32</option>

                                                            <option value="64">64</option>

                                                        </select>

                                                    </td>

                                                </tr>

                                                <tr>

                                                    <td align="left"><b>Rückspiel in der Gruppenphase:</b></td>

                                                    <td align="left">

                                                        <select name="turnierrueckspiel" size="1" class="form-control">

                                                            <option value="1">Ja</option>

                                                            <option value="2">Nein</option>

                                                        </select>

                                                    </td>

                                                </tr>

											<?php

											endif;

											?>

                                            <tr>

                                                <td align="left"><b>Anzahl Spielfelder:</b></td>

                                                <td align="left"><input type="number" name="turnierfelder" class="form-control" required/></td>

                                            </tr>

                                            <tr>

                                                <td align="left"><b>Spielzeit:</b></td>

                                                <td align="left"><input type="number" name="turnierspielzeit" class="form-control" required/></td>

                                            </tr>

											<?php

											if($online == 1):

												?>

                                                <tr>

                                                    <td align="left"><b>Beginn der Turnieranmeldung:</b></td>

                                                    <td align="left"><input type="datetime-local" name="turnieranmeldung" class="form-control" placeholder="YYYY-MM-DD HH:mm:ss" required/></td>

                                                </tr>

                                                <tr>

                                                    <td align="left"><b>Beginn des Turnier-Check-In's:</b></td>

                                                    <td align="left"><input type="datetime-local" name="turniercheckin" class="form-control" placeholder="YYYY-MM-DD HH:mm:ss" required/></td>

                                                </tr>

                                                <tr>

                                                    <td align="left"><b>Beginn des Turnier-Late Check-In's:</b></td>

                                                    <td align="left"><input type="datetime-local" name="turniercheckin2" class="form-control" placeholder="YYYY-MM-DD HH:mm:ss" required/></td>

                                                </tr>

											<?php

											endif;

											?>

                                            <tr>

                                                <td align="left"><b>Beginn des Turnieres:</b></td>

                                                <td align="left"><input type="datetime-local" name="turnierstart" class="form-control" placeholder="YYYY-MM-DD HH:mm:ss" required/></td>

                                            </tr>
                                            
                                            <tr>

                                                <td width="25%" align="left"><b>Logo des Turniers:</b></td>

                                                <td width="75%" align="left"><input type="text" name="logo" class="form-control" /></td>

                                            </tr>
                                            
                                            <tr>

                                                <td width="25%" align="left"><b>Link zum Livestream:</b></td>

                                                <td width="75%" align="left"><input type="text" name="livestream" class="form-control" /></td>

                                            </tr>
                                            
                                            <tr>

                                                <td width="25%" align="left"><b>Link zum Discord-Channel:</b></td>

                                                <td width="75%" align="left"><input type="text" name="discord" class="form-control" /></td>

                                            </tr>
                                            
                                            <tr>

                                                <td width="25%" align="left"><b>Titelbild:</b></td>

                                                <td width="75%" align="left"><input type="text" name="titelbild" class="form-control" /></td>

                                            </tr>

                                            <tr>

                                                <td width="100%" align="center" colspan="2">

                                                    <input type="hidden" name="turniermodus" value="<?=$turniermodus?>" />

                                                    <input type="hidden" name="online" value="<?=$online?>" />

                                                    <button type="submit" name="submit_turniererstellung2" class="btn btn-primary form-control">Turnier erstellen</button>

                                                </td>

                                            </tr>

                                        </table>

                                    </form>

                                </div>

                            </div>

                        </div>

					<?php



					else:



						?>

                        <div class="col-md-12">

                            <div class="container clearfix">

                                <div class="box table-responsive">

                                    <h2>Turniererstellung</h2>

                                    <form method="POST" action="">

                                        <table class="table table-bordered">

                                            <tr>

                                                <td width="25%" align="left"><b>Turniermodus:</b></td>

                                                <td width="75%" align="left">

                                                    <select name="turniermodus" size="1" class="form-control">

                                                        <option value="1">Gruppenphase</option>

                                                        <option value="2">KO-Runde</option>

                                                    </select>

                                                </td>

                                            </tr>

                                            <tr>

                                                <td align="left"><b>Online- / Offline-Turnier:</b></td>

                                                <td align="left">

                                                    <select name="online" size="1" class="form-control">

                                                        <option value="2">Offline-Turnier</option>

                                                        <option value="1">Online-Turnier</option>

                                                    </select>

                                                </td>

                                            </tr>

                                            <tr>

                                                <td width="100%" align="center" colspan="2">

                                                    <button type="submit" name="submit_turniererstellung1" class="btn btn-primary form-control">zu den erweiterten Einstellungen</button>

                                                </td>

                                            </tr>

                                        </table>

                                    </form>

                                </div>

                            </div>

                        </div>

					<?php



					endif;

					endif;



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

