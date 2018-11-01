<?php

session_start();

if (!isset($_SESSION["user_id"])):
    header("Location: ../../index.php?info=8");
elseif ($_SESSION["user_status"] == "admin"):
    header("Location: ../../index.php?info=9");
else:

$pageKey = 'user_statistics';
$pageName = 'Statistiken';

include("../functions/functions.php");
require_once "../templates/header.php";

$id = $_SESSION['user_id'];
$query_profile = mysqli_query($connection,"SELECT * FROM fifa_user WHERE user_id = '$id'");
$db_profile = $query_profile->fetch_object();
$user_name = $db_profile->user_vorname." ".$db_profile->user_nachname;


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
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="orange">
                                <i class="material-icons">timeline</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Meine Turniere</h4>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="text-primary">
                                        <tr>
                                            <th>ID</th>
                                            <th>Turnier</th>
                                            <th></th>
                                            <th></th>
                                        </tr></thead>
                                        <tbody>
                                        <?php
                                        $query_turniere = mysqli_query($connection,"SELECT * FROM b_turnierteams INNER JOIN b_turniere ON b_turnierteams.turniere_id = b_turniere.turniere_id WHERE b_turnierteams.team = '$user_name' ORDER BY b_turniere.turniere_id ASC");
                                        while($db = $query_turniere->fetch_object()){
                                        ?>
                                            <tr>
                                                <td><?php echo $db->turniere_id; ?></td>
                                                <td><?php echo $db->turniername; ?></td>
                                                <td>
                                                    <a class="btn btn-primary btn-round" href="<?php echo $domain; ?>scripts/turnierbereich/index.php?turnier=<?php echo $db->turniere_id; ?>&action=tabelle">
                                                        Tabelle
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class="btn btn-primary btn-round" href="<?php echo $domain; ?>scripts/turnierbereich/index.php?turnier=<?php echo $db->turniere_id; ?>&action=teilnehmer">
                                                        Teilnehmer
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
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