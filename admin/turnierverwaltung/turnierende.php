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

                    // Turnier beenden
                    $query_turnier = mysqli_query( $connection, "SELECT gestartet, beendet, turniername FROM b_turniere WHERE turniere_id = '$turniere_id'" );
                    $db_turnier    = $query_turnier->fetch_object();

                    if ( $db_turnier->gestartet == 2 || $db_turnier->beendet == 1 || countOffeneSpieleVonTurniereID( $turniere_id ) > 0 ):
	                    echo 'Es sind noch nicht alle Spiele beendet';
                    else:
	                    mysqli_query( $connection, "UPDATE b_turniere SET beendet = '1' WHERE turniere_id = '$turniere_id'" );
	                    mysqli_query( $connection, "UPDATE b_turnierteams SET beendet = '1' WHERE turniere_id = '$turniere_id'" );

	                    header( "Location: index.php" );
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