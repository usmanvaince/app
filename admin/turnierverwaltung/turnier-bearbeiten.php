<?php
$pageKey = 'user_dashboard';

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

                    // Turnier bearbeiten

                        var_dump($turniere_id);
                        $query_turnier = mysqli_query($connection, "SELECT * FROM b_turniere WHERE turniere_id = '$turniere_id'");
                        $db_turnier = $query_turnier->fetch_object();
                        $value_turnieranmeldung = date("Y-m-d", $db_turnier->turnieranmeldung) . "T" . date("H:i:s", $db_turnier->turnieranmeldung);
                        $value_turniercheckin = date("Y-m-d", $db_turnier->turniercheckin) . "T" . date("H:i:s", $db_turnier->turniercheckin);
                        $value_turniercheckin2 = date("Y-m-d", $db_turnier->turniercheckin2) . "T" . date("H:i:s", $db_turnier->turniercheckin2);
                        $value_turnierstart = date("Y-m-d", $db_turnier->turnierstart) . "T" . date("H:i:s", $db_turnier->turnierstart);

                        if (isset($_POST["submit_turnierbearbeitung"])):
                            $turniername = mysqli_real_escape_string($connection, $_POST["turniername"]);
                            $turnierort = mysqli_real_escape_string($connection, $_POST["turnierort"]);
                            $turnierlocation = mysqli_real_escape_string($connection, $_POST["turnierlocation"]);
                            $spielmodus = mysqli_real_escape_string($connection, $_POST["spielmodus"]);
                            $turnierteilnehmer = mysqli_real_escape_string($connection, $_POST["turnierteilnehmer"]);
                            $turniermodus = mysqli_real_escape_string($connection, $_POST["turniermodus"]);
                            $turniergruppen = mysqli_real_escape_string($connection, $_POST["turniergruppen"]);
                            $turnierrueckspiel = mysqli_real_escape_string($connection, $_POST["turnierrueckspiel"]);
                            $turnierfelder = mysqli_real_escape_string($connection, $_POST["turnierfelder"]);
                            $turnierspielzeit = mysqli_real_escape_string($connection, $_POST["turnierspielzeit"]);
                            $turnieranmeldung = mysqli_real_escape_string($connection, strtotime($_POST["turnieranmeldung"]));
                            $turniercheckin = mysqli_real_escape_string($connection, strtotime($_POST["turniercheckin"]));
                            $turniercheckin2 = mysqli_real_escape_string($connection, strtotime($_POST["turniercheckin2"]));
                            $turnierstart = mysqli_real_escape_string($connection, strtotime($_POST["turnierstart"]));

                            if ($turnierteilnehmer < $db_turnier->turnierteilnehmer):
                                mysqli_query($connection, "DELETE FROM b_turnierteams WHERE turniere_id = '$turniere_id' AND team_id > '$turnierteilnehmer'");
                            elseif ($turnierteilnehmer > $db_turnier->turnierteilnehmer):
                                for ($i = ($db_turnier->turnierteilnehmer + 1); $i <= $turnierteilnehmer; $i++):
                                    $team = "Team " . $i;

                                    mysqli_query($connection, "INSERT INTO b_turnierteams (turniere_id, team_id, team) VALUES ('$turniere_id', '$i', '$team')");
                                endfor;
                            endif;

                            if ($db_turnier->online == 1):
                                if ($turniermodus == 1):
                                    mysqli_query($connection, "UPDATE b_turniere SET turniername = '$turniername', turnierort = '$turnierort', turnierlocation = '$turnierlocation', spielmodus = '$spielmodus', turniermodus = '$turniermodus', turnierteilnehmer = '$turnierteilnehmer', turniergruppen = '$turniergruppen', turnierfelder = '$turnierfelder', turnierspielzeit = '$turnierspielzeit', turnieranmeldung = '$turnieranmeldung', turniercheckin = '$turniercheckin', turniercheckin2 = '$turniercheckin2', turnierstart = '$turnierstart', rueckspiel_gruppe = '$turnierrueckspiel' WHERE turniere_id = '$turniere_id'");
                                elseif ($turniermodus == 2):
                                    mysqli_query($connection, "UPDATE b_turniere SET turniername = '$turniername', turnierort = '$turnierort', turnierlocation = '$turnierlocation', spielmodus = '$spielmodus', turniermodus = '$turniermodus', turnierteilnehmer = '$turnierteilnehmer', turnierfelder = '$turnierfelder', turnierspielzeit = '$turnierspielzeit', turnieranmeldung = '$turnieranmeldung', turniercheckin = '$turniercheckin', turniercheckin2 = '$turniercheckin2', turnierstart = '$turnierstart' WHERE turniere_id = '$turniere_id'");
                                endif;
                            else:
                                if ($turniermodus == 1):
                                    mysqli_query($connection, "UPDATE b_turniere SET turniername = '$turniername', turnierort = '$turnierort', turnierlocation = '$turnierlocation', spielmodus = '$spielmodus', turniermodus = '$turniermodus', turnierteilnehmer = '$turnierteilnehmer', turniergruppen = '$turniergruppen', turnierfelder = '$turnierfelder', turnierspielzeit = '$turnierspielzeit', turnierstart = '$turnierstart', rueckspiel_gruppe = '$turnierrueckspiel' WHERE turniere_id = '$turniere_id'");
                                elseif ($turniermodus == 2):
                                    mysqli_query($connection, "UPDATE b_turniere SET turniername = '$turniername', turnierort = '$turnierort', turnierlocation = '$turnierlocation', spielmodus = '$spielmodus', turniermodus = '$turniermodus', turnierteilnehmer = '$turnierteilnehmer', turnierfelder = '$turnierfelder', turnierspielzeit = '$turnierspielzeit', turnierstart = '$turnierstart' WHERE turniere_id = '$turniere_id'");
                                endif;
                            endif;


                        endif;
                            ?>
                    <div class="col-md-12">
                        <div class="container clearfix">
                            <div class="box table-responsive">
                                <h2>Turnier bearbeiten</h2>
                                <form method="POST" action="">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td width="25%" align="left"><b>Turniername:</b></td>
                                            <td width="75%" align="left"><input type="text" name="turniername"
                                                                                class="form-control"
                                                                                value="<?= $db_turnier->turniername ?>"
                                                                                required/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="25%" align="left"><b>Turnierort:</b></td>
                                            <td width="75%" align="left"><input type="text" name="turnierort"
                                                                                class="form-control"
                                                                                value="<?= $db_turnier->turnierort ?>"
                                                                                required/>
                                            </td>
                                        <tr>
                                            <td width="25%" align="left"><b>Turnierlocation:</b></td>
                                            <td width="75%" align="left"><input type="text"
                                                                                name="turnierlocation"
                                                                                class="form-control"
                                                                                value="<?= $db_turnier->turnierlocation ?>"
                                                                                required/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left"><b>Spielmodus:</b></td>
                                            <td align="left">
                                                <select name="spielmodus" size="1" class="form-control">
                                                    <?php
                                                    if ($db_turnier->spielmodus == 1):
                                                        echo "<option value='1' selected='selected'>1 vs. 1</option>";
                                                        echo "<option value='2'>2 vs. 2</option>";
                                                    elseif ($db_turnier->spielmodus == 2):
                                                        echo "<option value='1'>1 vs. 1</option>";
                                                        echo "<option value='2' selected='selected'>2 vs. 2</option>";
                                                    endif;
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left"><b>max. Teilnehmer:</b></td>
                                            <td align="left">
                                                <select name="turnierteilnehmer" size="1" class="form-control">
                                                    <?php
                                                    if ($db_turnier->turnierteilnehmer == 8):
                                                        echo "<option value='8' selected='selected'>8</option>";
                                                        echo "<option value='16'>16</option>";
                                                        echo "<option value='32'>32</option>";
                                                        echo "<option value='64'>64</option>";
                                                        echo "<option value='80'>80</option>";
                                                        echo "<option value='96'>96</option>";
                                                        echo "<option value='128'>128</option>";
                                                        echo "<option value='192'>192</option>";
                                                        echo "<option value='256'>256</option>";
                                                    elseif ($db_turnier->turnierteilnehmer == 16):
                                                        echo "<option value='8'>8</option>";
                                                        echo "<option value='16' selected='selected'>16</option>";
                                                        echo "<option value='32'>32</option>";
                                                        echo "<option value='64'>64</option>";
                                                        echo "<option value='80'>80</option>";
                                                        echo "<option value='96'>96</option>";
                                                        echo "<option value='128'>128</option>";
                                                        echo "<option value='192'>192</option>";
                                                        echo "<option value='256'>256</option>";
                                                    elseif ($db_turnier->turnierteilnehmer == 32):
                                                        echo "<option value='8'>8</option>";
                                                        echo "<option value='16'>16</option>";
                                                        echo "<option value='32' selected='selected'>32</option>";
                                                        echo "<option value='64'>64</option>";
                                                        echo "<option value='80'>80</option>";
                                                        echo "<option value='96'>96</option>";
                                                        echo "<option value='128'>128</option>";
                                                        echo "<option value='192'>192</option>";
                                                        echo "<option value='256'>256</option>";
                                                    elseif ($db_turnier->turnierteilnehmer == 64):
                                                        echo "<option value='8'>8</option>";
                                                        echo "<option value='16'>16</option>";
                                                        echo "<option value='32'>32</option>";
                                                        echo "<option value='64' selected='selected'>64</option>";
                                                        echo "<option value='80'>80</option>";
                                                        echo "<option value='96'>96</option>";
                                                        echo "<option value='128'>128</option>";
                                                        echo "<option value='192'>192</option>";
                                                        echo "<option value='256'>256</option>";
                                                    elseif ($db_turnier->turnierteilnehmer == 80):
                                                        echo "<option value='8'>8</option>";
                                                        echo "<option value='16'>16</option>";
                                                        echo "<option value='32'>32</option>";
                                                        echo "<option value='64'>64</option>";
                                                        echo "<option value='80' selected='selected'>80</option>";
                                                        echo "<option value='96'>96</option>";
                                                        echo "<option value='128'>128</option>";
                                                        echo "<option value='192'>192</option>";
                                                        echo "<option value='256'>256</option>";
                                                    elseif ($db_turnier->turnierteilnehmer == 96):
                                                        echo "<option value='8'>8</option>";
                                                        echo "<option value='16'>16</option>";
                                                        echo "<option value='32'>32</option>";
                                                        echo "<option value='64'>64</option>";
                                                        echo "<option value='80'>80</option>";
                                                        echo "<option value='96' selected='selected'>96</option>";
                                                        echo "<option value='128'>128</option>";
                                                        echo "<option value='192'>192</option>";
                                                        echo "<option value='256'>256</option>";
                                                    elseif ($db_turnier->turnierteilnehmer == 128):
                                                        echo "<option value='8'>8</option>";
                                                        echo "<option value='16'>16</option>";
                                                        echo "<option value='32'>32</option>";
                                                        echo "<option value='64'>64</option>";
                                                        echo "<option value='80'>80</option>";
                                                        echo "<option value='96'>96</option>";
                                                        echo "<option value='128' selected='selected'>128</option>";
                                                        echo "<option value='192'>192</option>";
                                                        echo "<option value='256'>256</option>";
                                                    elseif ($db_turnier->turnierteilnehmer == 192):
                                                        echo "<option value='8'>8</option>";
                                                        echo "<option value='16'>16</option>";
                                                        echo "<option value='32'>32</option>";
                                                        echo "<option value='64'>64</option>";
                                                        echo "<option value='80'>80</option>";
                                                        echo "<option value='96'>96</option>";
                                                        echo "<option value='128'>128</option>";
                                                        echo "<option value='192' selected='selected'>192</option>";
                                                        echo "<option value='256'>256</option>";
                                                    elseif ($db_turnier->turnierteilnehmer == 256):
                                                        echo "<option value='8'>8</option>";
                                                        echo "<option value='16'>16</option>";
                                                        echo "<option value='32'>32</option>";
                                                        echo "<option value='64'>64</option>";
                                                        echo "<option value='80'>80</option>";
                                                        echo "<option value='96'>96</option>";
                                                        echo "<option value='128'>128</option>";
                                                        echo "<option value='192'>192</option>";
                                                        echo "<option value='256' selected='selected'>256</option>";
                                                    endif;
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left"><b>Turniermodus:</b></td>
                                            <td align="left">
                                                <select name="turniermodus" size="1" class="form-control">
                                                    <?php
                                                    if ($db_turnier->turniermodus == 1):
                                                        echo "<option value='1' selected='selected'>Gruppenphase</option>";
                                                        echo "<option value='2'>KO-Runde</option>";
                                                    elseif ($db_turnier->turniermodus == 2):
                                                        echo "<option value='1'>Gruppenphase</option>";
                                                        echo "<option value='2' selected='selected'>KO-Runde</option>";
                                                    endif;
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left"><b>Anzahl Gruppen:</b></td>
                                            <td align="left">
                                                <select name="turniergruppen" size="1" class="form-control">
                                                    <?php
                                                    if ($db_turnier->turniergruppen == 2):
                                                        echo "<option value='2' selected='selected'>2</option>";
                                                        echo "<option value='4'>4</option>";
                                                        echo "<option value='8'>8</option>";
                                                        echo "<option value='16'>16</option>";
                                                        echo "<option value='32'>32</option>";
                                                        echo "<option value='64'>64</option>";
                                                    elseif ($db_turnier->turniergruppen == 4):
                                                        echo "<option value='2'>2</option>";
                                                        echo "<option value='4' selected='selected'>4</option>";
                                                        echo "<option value='8'>8</option>";
                                                        echo "<option value='16'>16</option>";
                                                        echo "<option value='32'>32</option>";
                                                        echo "<option value='64'>64</option>";
                                                    elseif ($db_turnier->turniergruppen == 8):
                                                        echo "<option value='2'>2</option>";
                                                        echo "<option value='4'>4</option>";
                                                        echo "<option value='8' selected='selected'>8</option>";
                                                        echo "<option value='16'>16</option>";
                                                        echo "<option value='32'>32</option>";
                                                        echo "<option value='64'>64</option>";
                                                    elseif ($db_turnier->turniergruppen == 16):
                                                        echo "<option value='2'>2</option>";
                                                        echo "<option value='4'>4</option>";
                                                        echo "<option value='8'>8</option>";
                                                        echo "<option value='16' selected='selected'>16</option>";
                                                        echo "<option value='32'>32</option>";
                                                        echo "<option value='64'>64</option>";
                                                    elseif ($db_turnier->turniergruppen == 32):
                                                        echo "<option value='2'>2</option>";
                                                        echo "<option value='4'>4</option>";
                                                        echo "<option value='8'>8</option>";
                                                        echo "<option value='16'>16</option>";
                                                        echo "<option value='32' selected='selected'>32</option>";
                                                        echo "<option value='64'>64</option>";
                                                    elseif ($db_turnier->turniergruppen == 64):
                                                        echo "<option value='2'>2</option>";
                                                        echo "<option value='4'>4</option>";
                                                        echo "<option value='8'>8</option>";
                                                        echo "<option value='16'>16</option>";
                                                        echo "<option value='32'>32</option>";
                                                        echo "<option value='64' selected='selected'>64</option>";
                                                    endif;
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left"><b>Rückspiel in der Gruppenphase:</b></td>
                                            <td align="left">
                                                <select name="turnierrueckspiel" size="1" class="form-control">
                                                    <?php
                                                    if ($db_turnier->rueckspiel_gruppe == 1):
                                                        echo "<option value='1' selected='selected'>Ja</option>";
                                                        echo "<option value='2'>Nein</option>";
                                                    elseif ($db_turnier->rueckspiel_gruppe == 2):
                                                        echo "<option value='1'>Ja</option>";
                                                        echo "<option value='2' selected='selected'>Nein</option>";
                                                    endif;
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left"><b>Anzahl Spielfelder:</b></td>
                                            <td align="left"><input type="number" name="turnierfelder"
                                                                    class="form-control"
                                                                    value="<?= $db_turnier->turnierfelder ?>"
                                                                    required/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left"><b>Spielzeit:</b></td>
                                            <td align="left"><input type="number" name="turnierspielzeit"
                                                                    class="form-control"
                                                                    value="<?= $db_turnier->turnierspielzeit ?>"
                                                                    required/></td>
                                        </tr>
                                        <?php
                                        if ($db_turnier->online == 1):
                                            ?>
                                            <tr>
                                                <td align="left"><b>Beginn der Turnieranmeldung:</b></td>
                                                <td align="left">
                                                    <input type="datetime-local" name="turnieranmeldung"
                                                           class="form-control"
                                                           value="<?= $value_turnieranmeldung ?>" required/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left"><b>Beginn des Turnier-Check-In's:</b></td>
                                                <td align="left">
                                                    <input type="datetime-local" name="turniercheckin"
                                                           class="form-control"
                                                           value="<?= $value_turniercheckin ?>" required/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left"><b>Beginn des Turnier-Late Check-In's:</b></td>
                                                <td align="left">
                                                    <input type="datetime-local" name="turniercheckin2"
                                                           class="form-control"
                                                           value="<?= $value_turniercheckin2 ?>" required/>
                                                </td>
                                            </tr>
                                        <?php
                                        endif;
                                        ?>
                                        <tr>
                                            <td align="left"><b>Beginn des Turnieres:</b></td>
                                            <td align="left"><input type="datetime-local" name="turnierstart"
                                                                    class="form-control"
                                                                    value="<?= $value_turnierstart ?>"
                                                                    required/></td>
                                        </tr>
                                        <tr>
                                            <td width="100%" align="center" colspan="2">
                                                <input name="turnier_id" type="hidden"
                                                       value="<?php echo $turniere_id; ?>">
                                                <button type="submit" name="submit_turnierbearbeitung"
                                                        class="btn btn-primary form-control">Änderungen
                                                    speichern
                                                </button>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php





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