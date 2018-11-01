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

                    <?php

                    // Spielergebnisse eingtragen

                    if (isset($_POST["submit_turnierwertung"])):
                        $spiele_id = mysqli_real_escape_string($connection, $_POST["spiele_id"]);
                        $tore_heim = mysqli_real_escape_string($connection, $_POST["tore_heim"]);
                        $tore_gast = mysqli_real_escape_string($connection, $_POST["tore_gast"]);
                        $spielinfo = mysqli_real_escape_string($connection, $_POST["spielinfo"]);

                        $query_turnier = mysqli_query($connection, "SELECT spiele_id_next, turnierspiele_id, turniere_id, team_heim, team_gast FROM b_spiele WHERE spiele_id = '$spiele_id'");
                        $db_turnier = $query_turnier->fetch_object();

                        if (checkBelegungVonTurnierspieleID($db_turnier->turniere_id, $db_turnier->spiele_id_next) == 1):
                            $sql = "datum = '$time',";
                        else:
                            $sql = "datum = NULL,";
                        endif;

                        mysqli_query($connection, "UPDATE b_spiele SET status = '1', tore_heim = NULL, tore_gast = NULL, spielinfo = NULL WHERE spiele_id = '$spiele_id'");

                        if (getTurniermodusIDVonTurniereID($db_turnier->turniere_id) == 1):
                            mysqli_query($connection, "UPDATE b_spiele SET status = '2', tore_heim = '$tore_heim', tore_gast = '$tore_gast', spielinfo = '$spielinfo' WHERE spiele_id = '$spiele_id'");
                        elseif (getTurniermodusIDVonTurniereID($db_turnier->turniere_id) == 2):
                            if ($tore_heim > $tore_gast):
                                mysqli_query($connection, "UPDATE b_spiele SET status = '2', tore_heim = '$tore_heim', tore_gast = '$tore_gast', spielinfo = '$spielinfo' WHERE spiele_id = '$spiele_id'");
                                mysqli_query($connection, "UPDATE b_turnierteams SET beendet = '2' WHERE turniere_id = '$db_turnier->turniere_id' AND (team_id = '$db_turnier->team_heim' OR team_id = '$db_turnier->team_gast')");
                                mysqli_query($connection, "UPDATE b_turnierteams SET beendet = '1' WHERE turniere_id = '$db_turnier->turniere_id' AND team_id = '$db_turnier->team_gast'");

                                if ($db_turnier->spiele_id_next == (getTurnierteilnehmerVonTurniereID($db_turnier->turniere_id) - 1)):
                                    if ($db_turnier->turnierspiele_id % 2 == 0):
                                        mysqli_query($connection, "UPDATE b_spiele SET " . $sql . " team_gast = '$db_turnier->team_heim' WHERE turniere_id = '$db_turnier->turniere_id' AND turnierspiele_id = '" . ($db_turnier->spiele_id_next + 1) . "'");
                                        mysqli_query($connection, "UPDATE b_spiele SET " . $sql . " team_gast = '$db_turnier->team_gast' WHERE turniere_id = '$db_turnier->turniere_id' AND turnierspiele_id = '$db_turnier->spiele_id_next'");
                                    else:
                                        mysqli_query($connection, "UPDATE b_spiele SET " . $sql . " team_heim = '$db_turnier->team_heim' WHERE turniere_id = '$db_turnier->turniere_id' AND turnierspiele_id = '" . ($db_turnier->spiele_id_next + 1) . "'");
                                        mysqli_query($connection, "UPDATE b_spiele SET " . $sql . " team_heim = '$db_turnier->team_gast' WHERE turniere_id = '$db_turnier->turniere_id' AND turnierspiele_id = '$db_turnier->spiele_id_next'");
                                    endif;
                                else:
                                    if ($db_turnier->turnierspiele_id % 2 == 0):
                                        mysqli_query($connection, "UPDATE b_spiele SET " . $sql . " team_gast = '$db_turnier->team_heim' WHERE turniere_id = '$db_turnier->turniere_id' AND turnierspiele_id = '$db_turnier->spiele_id_next'");
                                    else:
                                        mysqli_query($connection, "UPDATE b_spiele SET " . $sql . " team_heim = '$db_turnier->team_heim' WHERE turniere_id = '$db_turnier->turniere_id' AND turnierspiele_id = '$db_turnier->spiele_id_next'");
                                    endif;
                                endif;
                            elseif ($tore_heim == $tore_gast):
                                header("Location: index.php?info=12");
                            elseif ($tore_heim < $tore_gast):
                                mysqli_query($connection, "UPDATE b_spiele SET status = '2', tore_heim = '$tore_heim', tore_gast = '$tore_gast', spielinfo = '$spielinfo' WHERE spiele_id = '$spiele_id'");
                                mysqli_query($connection, "UPDATE b_turnierteams SET beendet = '2' WHERE turniere_id = '$db_turnier->turniere_id' AND (team_id = '$db_turnier->team_heim' OR team_id = '$db_turnier->team_gast')");
                                mysqli_query($connection, "UPDATE b_turnierteams SET beendet = '1' WHERE turniere_id = '$db_turnier->turniere_id' AND trainer_id = '$db_turnier->team_heim'");

                                if ($db_turnier->spiele_id_next == (getTurnierteilnehmerVonTurniereID($db_turnier->turniere_id) - 1)):
                                    if ($db_turnier->turnierspiele_id % 2 == 0):
                                        mysqli_query($connection, "UPDATE b_spiele SET " . $sql . " team_gast = '$db_turnier->team_gast' WHERE turniere_id = '$db_turnier->turniere_id' AND turnierspiele_id = '" . ($db_turnier->spiele_id_next + 1) . "'");
                                        mysqli_query($connection, "UPDATE b_spiele SET " . $sql . " team_gast = '$db_turnier->team_heim' WHERE turniere_id = '$db_turnier->turniere_id' AND turnierspiele_id = '$db_turnier->spiele_id_next'");
                                    else:
                                        mysqli_query($connection, "UPDATE b_spiele SET " . $sql . " team_heim = '$db_turnier->team_gast' WHERE turniere_id = '$db_turnier->turniere_id' AND turnierspiele_id = '" . ($db_turnier->spiele_id_next + 1) . "'");
                                        mysqli_query($connection, "UPDATE b_spiele SET " . $sql . " team_heim = '$db_turnier->team_heim' WHERE turniere_id = '$db_turnier->turniere_id' AND turnierspiele_id = '$db_turnier->spiele_id_next'");
                                    endif;
                                else:
                                    if ($db_turnier->turnierspiele_id % 2 == 0):
                                        mysqli_query($connection, "UPDATE b_spiele SET " . $sql . " team_gast = '$db_turnier->team_gast' WHERE turniere_id = '$db_turnier->turniere_id' AND turnierspiele_id = '$db_turnier->spiele_id_next'");
                                    else:
                                        mysqli_query($connection, "UPDATE b_spiele SET " . $sql . " team_heim = '$db_turnier->team_gast' WHERE turniere_id = '$db_turnier->turniere_id' AND turnierspiele_id = '$db_turnier->spiele_id_next'");
                                    endif;
                                endif;
                            endif;
                        endif;

                        // header("Location: index.php?turnier=" . $turniere_id . "&action=turnierwertung");
                    endif;
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <select id="admin--open-games-select-box" title="Single Select" data-size="7">


                        <?php
                        $query = mysqli_query($connection, "SELECT spiele_id, turnierspiele_id, spielort, gruppe, spieltag, team_heim, team_gast, tore_heim, tore_gast, spielinfo, datum FROM b_spiele WHERE status = '1' AND turniere_id = '$turniere_id' ORDER BY turnierspiele_id ASC");
                        while ($db = $query->fetch_object()):
                            ?>
                            <option value='<?= $db->turnierspiele_id ?>'><?= $db->turnierspiele_id ?></option>
                        <?php
                        endwhile;
                        ?>
                            </select>
                            <button id="admin--open-games-select-id">
                                Spiel wählen
                            </button>
                            <div id="admin--open-games-quick" class="box table-responsive">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box table-responsive wrap--admin-open-games">
                                <h2>Offene Turnierspiele
                                    (noch <?= countOffeneSpieleVonTurniereID($turniere_id) ?>
                                    Spiele)</h2>

                                <?php
                                $query = mysqli_query($connection, "SELECT spiele_id, turnierspiele_id, spielort, gruppe, spieltag, team_heim, team_gast, tore_heim, tore_gast, spielinfo, datum FROM b_spiele WHERE status = '1' AND turniere_id = '$turniere_id' ORDER BY turnierspiele_id ASC");
                                while ($db = $query->fetch_object()):
                                    if (isset($db->tore_heim) && isset($db->tore_gast)):
                                        $color = " bgcolor='#32CD32'";
                                    else:
                                        $color = "";
                                    endif;
                                    ?>
                                    <form method="POST" action="" data-game-id="<?= $db->turnierspiele_id ?>">
                                        <table class="table table-bordered">
                                            <tr bgcolor="#E8E8E8">
                                                <td width="5%" align="center"><b>ID</b></td>
                                                <td width="5%" align="center"><b>Spielort</b></td>
                                                <td width="5%" align="center"><b>Zeit</b></td>
                                                <td width="5%" align="center"><b>Gruppe</b></td>
                                                <td width="5%" align="center"><b>Spieltag</b></td>
                                                <td width="20%" align="right"><b>Heim</b></td>
                                                <td width="5%" align="center">&nbsp;</td>
                                                <td width="5%" align="center">&nbsp;</td>
                                                <td width="20%" align="left"><b>Gast</b></td>
                                                <td width="15%" align="center"><b>Info</b></td>
                                                <td width="10%" align="center">&nbsp;</td>
                                            </tr>

                                            <!-- dem form -->
                                            <tr<?= $color ?>>

                                                <td align="center"><?= $db->turnierspiele_id ?></td>
                                                <td align="center"><?= $db->spielort ?></td>
                                                <td align="center">
                                                    <?php
                                                    if (isset($db->datum)):
                                                        echo date("H:i", $db->datum) . " Uhr";
                                                    endif;
                                                    ?>
                                                </td>
                                                <td align="center"><?= $db->gruppe ?></td>
                                                <td align="center">
                                                    <?php
                                                    if (getTurniermodusIDVonTurniereID($turniere_id) == 1):
                                                        echo $db->spieltag;
                                                    else:
                                                        echo getShortTurnierrundenname(getTurnierrundenteilnehmerVonTurniereID($turniere_id, $db->spieltag), $turniere_id, $db->spieltag);
                                                    endif;
                                                    ?>
                                                </td>
                                                <td align="right"><?= getTurnierteamVonTurnierteamID($turniere_id, $db->team_heim) ?>
                                                    (<?= $db->team_heim ?>)
                                                </td>
                                                <td align="center"><input type="number" name="tore_heim"
                                                                          class="form-control"
                                                                          value="<?= $db->tore_heim ?>"
                                                                          required/></td>
                                                <td align="center"><input type="number" name="tore_gast"
                                                                          class="form-control"
                                                                          value="<?= $db->tore_gast ?>"
                                                                          required/></td>
                                                <td align="left">(<?= $db->team_gast ?>
                                                    ) <?= getTurnierteamVonTurnierteamID($turniere_id, $db->team_gast) ?></td>
                                                <td align="center">

                                                    <select title="Single Select" name="spielinfo" data-size="7">
                                                        <option value='1'>Reguläre Spielzeit</option>
                                                        <option value='2'>nach Verlängerung</option>
                                                        <option value='3'>nach Elfmeterschießen</option>
                                                    </select>
                                                </td>
                                                <td align="center">
                                                    <?php
                                                    if (isset($db->team_heim) && isset($db->team_gast)):
                                                        ?>
                                                        <input type="hidden" name="spiele_id"
                                                               value="<?= $db->spiele_id ?>"/>
                                                        <input name="turnier_id" type="hidden"
                                                               value="<?php echo $turniere_id; ?>">
                                                        <button type="submit" name="submit_turnierwertung"
                                                                class="btn btn-primary form-control">Eintragen
                                                        </button>
                                                    <?php
                                                    endif;
                                                    ?>
                                                </td>

                                            </tr>
                                        </table>
                                    </form>
                                <?php
                                endwhile;
                                ?>

                            </div>
                            <div class="box table-responsive wrap--admin-open-games">
                                <h2>Eingetragene Turnierspiele</h2>

                                <?php
                                $query = mysqli_query($connection, "SELECT spiele_id, turnierspiele_id, spielort, gruppe, spieltag, team_heim, team_gast, tore_heim, tore_gast, spielinfo, datum FROM b_spiele WHERE status = '2' AND turniere_id = '$turniere_id' ORDER BY turnierspiele_id ASC");
                                while ($db = $query->fetch_object()):
                                    if (isset($db->tore_heim) && isset($db->tore_gast)):
                                        $color = " bgcolor='#32CD32'";
                                    else:
                                        $color = "";
                                    endif;
                                    ?>
                                    <form method="POST" action="">
                                        <table class="table table-bordered">
                                            <tr bgcolor="#E8E8E8">
                                                <td width="5%" align="center"><b>ID</b></td>
                                                <td width="5%" align="center"><b>Spielort</b></td>
                                                <td width="5%" align="center"><b>Zeit</b></td>
                                                <td width="5%" align="center"><b>Gruppe</b></td>
                                                <td width="5%" align="center"><b>Spieltag</b></td>
                                                <td width="20%" align="right"><b>Heim</b></td>
                                                <td width="5%" align="center">&nbsp;</td>
                                                <td width="5%" align="center">&nbsp;</td>
                                                <td width="20%" align="left"><b>Gast</b></td>
                                                <td width="15%" align="center"><b>Info</b></td>
                                                <td width="10%" align="center">&nbsp;</td>
                                            </tr>
                                            <tr<?= $color ?>>
                                                <td align="center"><?= $db->turnierspiele_id ?></td>
                                                <td align="center"><?= $db->spielort ?></td>
                                                <td align="center">
                                                    <?php
                                                    if (isset($db->datum)):
                                                        echo date("H:i", $db->datum) . " Uhr";
                                                    endif;
                                                    ?>
                                                </td>
                                                <td align="center"><?= $db->gruppe ?></td>
                                                <td align="center">
                                                    <?php
                                                    if (getTurniermodusIDVonTurniereID($turniere_id) == 1):
                                                        echo $db->spieltag;
                                                    else:
                                                        echo getShortTurnierrundenname(getTurnierrundenteilnehmerVonTurniereID($turniere_id, $db->spieltag), $turniere_id, $db->spieltag);
                                                    endif;
                                                    ?>
                                                </td>
                                                <td align="right"><?= getTurnierteamVonTurnierteamID($turniere_id, $db->team_heim) ?>
                                                    (<?= $db->team_heim ?>)
                                                </td>
                                                <td align="center"><input type="number" name="tore_heim"
                                                                          class="form-control"
                                                                          value="<?= $db->tore_heim ?>"
                                                                          required/></td>
                                                <td align="center"><input type="number" name="tore_gast"
                                                                          class="form-control"
                                                                          value="<?= $db->tore_gast ?>"
                                                                          required/></td>
                                                <td align="left">(<?= $db->team_gast ?>
                                                    ) <?= getTurnierteamVonTurnierteamID($turniere_id, $db->team_gast) ?></td>
                                                <td align="center">
                                                    <select name="spielinfo" size="1" class="form-control">
                                                        <?php
                                                        if ($db->spielinfo == 0 || $db->spielinfo == 1):
                                                            echo "<option value='1' selected='selected'>Reguläre Spielzeit</option>";
                                                            echo "<option value='2'>nach Verlängerung</option>";
                                                            echo "<option value='3'>nach Elfmeterschießen</option>";
                                                        elseif ($db->spielinfo == 2):
                                                            echo "<option value='1'>Reguläre Spielzeit</option>";
                                                            echo "<option value='2' selected='selected'>nach Verlängerung</option>";
                                                            echo "<option value='3'>nach Elfmeterschießen</option>";
                                                        elseif ($db->spielinfo == 3):
                                                            echo "<option value='1'>Reguläre Spielzeit</option>";
                                                            echo "<option value='2'>nach Verlängerung</option>";
                                                            echo "<option value='3' selected='selected'>nach Elfmeterschießen</option>";
                                                        endif;
                                                        ?>
                                                    </select>
                                                </td>
                                                <td align="center">
                                                    <?php
                                                    if (isset($db->team_heim) && isset($db->team_gast)):
                                                        ?>
                                                        <input type="hidden" name="spiele_id"
                                                               value="<?= $db->spiele_id ?>"/>
                                                        <input name="turnier_id" type="hidden"
                                                               value="<?php echo $turniere_id; ?>">
                                                        <button type="submit" name="submit_turnierwertung"
                                                                class="btn btn-primary form-control">Eintragen
                                                        </button>
                                                    <?php
                                                    endif;
                                                    ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                <?php
                                endwhile;
                                ?>
                            </div>
                        </div>
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