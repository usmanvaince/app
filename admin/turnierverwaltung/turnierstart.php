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
                        $turniere_id = $_POST['turnier_id'];
                        var_dump($turniere_id);
                        // Turnierstart

                        // Formular submint_turnierstart abgesendet
                        if (isset($_POST["submit_turnierstart"])):
                            $query_turnier = mysqli_query($connection, "SELECT turniername, turniermodus, turnierteilnehmer, turniergruppen, turnierfelder, turnierspielzeit, turnierstart, rueckspiel_gruppe, gestartet, online FROM b_turniere WHERE turniere_id = '$turniere_id'");
                            $db_turnier = $query_turnier->fetch_object();

                            if ($db_turnier->gestartet == 1):
                                header("Location: index.php");
                            else:

                                /* Erstellt die Auslosung für das Turnier
                                 *
                                 *
                                 *
                                 * */

                                // Falls Grupperphase
                                if ($db_turnier->turniermodus == 1):
                                    $teams = array();

                                    $query = mysqli_query($connection, "SELECT team_id FROM b_turnierteams WHERE turniere_id = '$turniere_id' AND beendet = '2'");
                                    while ($db = $query->fetch_object()):
                                        $teams[] = $db->team_id;
                                    endwhile;

                                    shuffle($teams);
                                    $groups = array_chunk($teams, ($db_turnier->turnierteilnehmer / $db_turnier->turniergruppen));

                                    for ($g = 0; $g < $db_turnier->turniergruppen; $g++):
                                        $gruppe = $g + 1;

                                        // Benötigte Variablen setzen
                                        $anz = count($groups[$g]);

                                        if ($anz == 3):
                                            $plan[1][1]["H"] = $groups[$g][0];
                                            $plan[1][1]["G"] = $groups[$g][1];

                                            $plan[2][1]["H"] = $groups[$g][2];
                                            $plan[2][1]["G"] = $groups[$g][0];

                                            $plan[3][1]["H"] = $groups[$g][1];
                                            $plan[3][1]["G"] = $groups[$g][2];

                                            if ($db_turnier->rueckspiel_gruppe == 1):
                                                $plan[4][1]["H"] = $groups[$g][1];
                                                $plan[4][1]["G"] = $groups[$g][0];

                                                $plan[5][1]["H"] = $groups[$g][0];
                                                $plan[5][1]["G"] = $groups[$g][2];

                                                $plan[6][1]["H"] = $groups[$g][2];
                                                $plan[6][1]["G"] = $groups[$g][1];
                                            endif;
                                        elseif ($anz == 4):
                                            $plan[1][1]["H"] = $groups[$g][0];
                                            $plan[1][1]["G"] = $groups[$g][1];
                                            $plan[1][2]["H"] = $groups[$g][2];
                                            $plan[1][2]["G"] = $groups[$g][3];

                                            $plan[2][1]["H"] = $groups[$g][3];
                                            $plan[2][1]["G"] = $groups[$g][0];
                                            $plan[2][2]["H"] = $groups[$g][1];
                                            $plan[2][2]["G"] = $groups[$g][2];

                                            $plan[3][1]["H"] = $groups[$g][0];
                                            $plan[3][1]["G"] = $groups[$g][2];
                                            $plan[3][2]["H"] = $groups[$g][3];
                                            $plan[3][2]["G"] = $groups[$g][1];

                                            if ($db_turnier->rueckspiel_gruppe == 1):
                                                $plan[4][1]["H"] = $groups[$g][1];
                                                $plan[4][1]["G"] = $groups[$g][0];
                                                $plan[4][2]["H"] = $groups[$g][3];
                                                $plan[4][2]["G"] = $groups[$g][2];

                                                $plan[5][1]["H"] = $groups[$g][0];
                                                $plan[5][1]["G"] = $groups[$g][3];
                                                $plan[5][2]["H"] = $groups[$g][2];
                                                $plan[5][2]["G"] = $groups[$g][1];

                                                $plan[6][1]["H"] = $groups[$g][2];
                                                $plan[6][1]["G"] = $groups[$g][0];
                                                $plan[6][2]["H"] = $groups[$g][1];
                                                $plan[6][2]["G"] = $groups[$g][3];
                                            endif;
                                        elseif ($anz == 5):
                                            $plan[1][1]["H"] = $groups[$g][0];
                                            $plan[1][1]["G"] = $groups[$g][1];
                                            $plan[1][2]["H"] = $groups[$g][4];
                                            $plan[1][2]["G"] = $groups[$g][2];

                                            $plan[2][1]["H"] = $groups[$g][2];
                                            $plan[2][1]["G"] = $groups[$g][0];
                                            $plan[2][2]["H"] = $groups[$g][3];
                                            $plan[2][2]["G"] = $groups[$g][4];

                                            $plan[3][1]["H"] = $groups[$g][0];
                                            $plan[3][1]["G"] = $groups[$g][3];
                                            $plan[3][2]["H"] = $groups[$g][1];
                                            $plan[3][2]["G"] = $groups[$g][2];

                                            $plan[4][1]["H"] = $groups[$g][3];
                                            $plan[4][1]["G"] = $groups[$g][1];
                                            $plan[4][2]["H"] = $groups[$g][4];
                                            $plan[4][2]["G"] = $groups[$g][0];

                                            $plan[5][1]["H"] = $groups[$g][1];
                                            $plan[5][1]["G"] = $groups[$g][4];
                                            $plan[5][2]["H"] = $groups[$g][2];
                                            $plan[5][2]["G"] = $groups[$g][3];

                                            if ($db_turnier->rueckspiel_gruppe == 1):
                                                $plan[6][1]["H"] = $groups[$g][1];
                                                $plan[6][1]["G"] = $groups[$g][0];
                                                $plan[6][2]["H"] = $groups[$g][2];
                                                $plan[6][2]["G"] = $groups[$g][4];

                                                $plan[7][1]["H"] = $groups[$g][0];
                                                $plan[7][1]["G"] = $groups[$g][2];
                                                $plan[7][2]["H"] = $groups[$g][4];
                                                $plan[7][2]["G"] = $groups[$g][3];

                                                $plan[8][1]["H"] = $groups[$g][3];
                                                $plan[8][1]["G"] = $groups[$g][0];
                                                $plan[8][2]["H"] = $groups[$g][2];
                                                $plan[8][2]["G"] = $groups[$g][1];

                                                $plan[9][1]["H"] = $groups[$g][1];
                                                $plan[9][1]["G"] = $groups[$g][3];
                                                $plan[9][2]["H"] = $groups[$g][0];
                                                $plan[9][2]["G"] = $groups[$g][4];

                                                $plan[10][1]["H"] = $groups[$g][4];
                                                $plan[10][1]["G"] = $groups[$g][1];
                                                $plan[10][2]["H"] = $groups[$g][3];
                                                $plan[10][2]["G"] = $groups[$g][2];
                                            endif;
                                        endif;

                                        // Sortierung nach Spieltag
                                        ksort($plan);

                                        foreach ($plan AS $spieltag => $v1):
                                            foreach ($v1 AS $spielnummer => $v2):
                                                mysqli_query($connection, "INSERT INTO b_spiele (status, turniere_id, spieltag, gruppe, team_heim, team_gast) VALUES ('1', '$turniere_id', '$spieltag', '$gruppe', '" . $plan[$spieltag][$spielnummer]["H"] . "', '" . $plan[$spieltag][$spielnummer]["G"] . "')");
                                            endforeach;
                                        endforeach;
                                    endfor;

                                    $spielnr = 0;
                                    $spielenr = 1;
                                    $tvnr = 0;

                                    $query = mysqli_query($connection, "SELECT * FROM b_spiele WHERE turniere_id = '$turniere_id' ORDER BY spieltag ASC, gruppe ASC, spiele_id ASC");
                                    while ($db = $query->fetch_object()):
                                        $tvnr++;
                                        $spielort = "TV " . $tvnr;

                                        if ($spielnr < $db_turnier->turnierfelder):
                                            $datum = $db_turnier->turnierstart;
                                        else:
                                            if ($spielnr % $db_turnier->turnierfelder == 0):
                                                $datum += ($db_turnier->turnierspielzeit * 60);
                                            endif;
                                        endif;

                                        mysqli_query($connection, "UPDATE b_spiele SET turnierspiele_id = '$spielenr', spielort = '$spielort', datum = '$datum' WHERE spiele_id = '$db->spiele_id'");

                                        $spielnr++;
                                        $spielenr++;

                                        if ($tvnr == $db_turnier->turnierfelder):
                                            $tvnr = 0;
                                        endif;
                                    endwhile;

                                    mysqli_query($connection, "UPDATE b_turniere SET gestartet = '1' WHERE turniere_id = '$turniere_id'");


                                // Turniermodus ist K.O.-Phase
                                elseif ($db_turnier->turniermodus == 2):
                                    ErstelleBracketVonTurniereID($turniere_id);

                                    $teams = array();

                                    $query = mysqli_query($connection, "SELECT team_id FROM b_turnierteams WHERE turniere_id = '$turniere_id' AND beendet = '2'");
                                    while ($db = $query->fetch_object()):
                                        $teams[] = $db->team_id;
                                    endwhile;

                                    shuffle($teams);
                                    $pairs = array_chunk($teams, 2);

                                    foreach ($pairs AS $pair):
                                        $arHeim[] = $pair[0];
                                        $arGast[] = $pair[1];
                                    endforeach;

                                    $spielnr = 0;
                                    $tvnr = 0;

                                    $query = mysqli_query($connection, "SELECT * FROM b_spiele WHERE turniere_id = '$turniere_id' AND spieltag = '1' ORDER BY spiele_id ASC");
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

                                        mysqli_query($connection, "UPDATE b_spiele SET team_heim = '" . $arHeim[$spielnr] . "', team_gast = '" . $arGast[$spielnr] . "', spielort = '$spielort', datum = '$datum' WHERE spiele_id = '$db->spiele_id'");

                                        $spielnr++;

                                        if ($tvnr == $db_turnier->turnierfelder):
                                            $tvnr = 0;
                                        endif;
                                    endwhile;

                                    mysqli_query($connection, "UPDATE b_turniere SET gestartet = '1' WHERE turniere_id = '$turniere_id'");
                                endif;

                                header("Location: index.php");
                            endif;


                        // Ansonsten Button für Turnierstart anzeigen
                        else:

                            ?>
                            <div class="col-md-12">
                                <div class="box table-responsive">
                                    <h2><?= getTurniernameVonTurniereID($turniere_id) ?> - Turnierstart</h2>
                                    <form method="POST" action="">
                                        <input name="turnier_id" type="hidden" value="<?php echo $turniere_id; ?>">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td width="100%" align="center">Wollen Sie das Turnier wirklich
                                                    starten?
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <button type="submit" name="submit_turnierstart"
                                                            class="btn btn-primary form-control">Turnier wirklich
                                                        starten
                                                    </button>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                </div>
                            </div>
                        <?php
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

<?php endif; ?>