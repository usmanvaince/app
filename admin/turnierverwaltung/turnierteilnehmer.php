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

                    // Teilnehmerliste anzeigen

                        $turniere_id = $_POST['turnier_id'];

                        if (isset($_POST["submit_turnierteilnehmer"])):
                            $turniere_id = mysqli_real_escape_string($connection, $_POST["turniere_id"]);
                            $team_id = mysqli_real_escape_string($connection, $_POST["team_id"]);
                            $team = mysqli_real_escape_string($connection, $_POST["team"]);
                            $confirmed = mysqli_real_escape_string($connection, $_POST["confirmed"]);

                            mysqli_query($connection, "UPDATE b_turnierteams SET team = '$team', confirmed = '$confirmed' WHERE turniere_id = '$turniere_id' AND team_id = '$team_id'");

                           endif;
                            ?>
                            <div class="col-md-12">
                                <div class="container clearfix">
                                    <div class="box table-responsive">
                                        <h2><?= getTurniernameVonTurniereID($turniere_id) ?> - Teilnehmer</h2>
                                        <table class="table table-bordered">
                                            <tr bgcolor="#E8E8E8">
                                                <td width="5%" align="center"><b>ID</b></td>
                                                <td width="75%" align="left"><b>Team</b></td>
                                                <td width="10%" align="center"><b>Check-In bestätigt?</b></td>
                                                <td width="10%" align="center">&nbsp;</td>
                                            </tr>
                                            <?php
                                            $query = mysqli_query($connection, "SELECT turnierteams_id, team_id, team, confirmed FROM b_turnierteams WHERE turniere_id = '$turniere_id' ORDER BY team_id ASC");
                                            while ($db = $query->fetch_object()):
                                                ?>

                                                <form method="POST" action="">
                                                    
                                                    <tr>
                                                        <td align="center"><?= $db->team_id ?></td>
                                                        <td align="left">
                                                            <div class="form-group label-floating is-empty">
                                                                <label class="control-label">Team</label>
                                                                <input type="text" name="team" class="form-control"
                                                                       value="<?= $db->team ?>">
                                                                <span class="material-input"></span>
                                                            </div>
                                                        <td align="center">
                                                            <select name="confirmed" class="selectpicker"
                                                                    data-style="btn btn-primary btn-round"
                                                                    title="Single Select"
                                                                    data-size="7">
                                                                <option value="1" <?php if($db->confirmed == 1){ echo 'selected'; } ?>>Bestätigt</option>
                                                                <option value="2" <?php if($db->confirmed == 2){ echo 'selected'; } ?>>Noch offen</option>
                                                            </select>
                                                        </td>
                                                        <td align="center">
                                                            <input type="hidden" name="turniere_id"
                                                                   value="<?= $turniere_id ?>"/>
                                                            <input type="hidden" name="team_id"
                                                                   value="<?= $db->team_id ?>"/>
                                                            <button type="submit" name="submit_turnierteilnehmer"
                                                                    class="btn btn-primary form-control">Bearbeiten
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    
                                                </form>

                                            <?php
                                            endwhile;
                                            ?>
										</table>
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