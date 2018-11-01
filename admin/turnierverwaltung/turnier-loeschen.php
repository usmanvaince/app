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

                    // Turnier löschen


                    $query_turnier = mysqli_query( $connection, "SELECT gestartet FROM b_turniere WHERE turniere_id = '$turniere_id'" );
                    $db_turnier    = $query_turnier->fetch_object();

                    if ( $db_turnier->gestartet == 1 ):
	                    header( "Location: index.php?info=10" );
                    else:
	                    mysqli_query( $connection, "DELETE FROM b_spiele WHERE turniere_id = '$turniere_id'" );
	                    mysqli_query( $connection, "DELETE FROM b_turniere WHERE turniere_id = '$turniere_id'" );
	                    mysqli_query( $connection, "DELETE FROM b_turnierteams WHERE turniere_id = '$turniere_id'" );

	                    header( "Location: index.php" );
                    endif;

                    if (isset($_POST["submit_turnierentfernung"])):

                        mysqli_query($connection, "DELETE FROM b_spiele WHERE turniere_id = '$turniere_id'");
                        mysqli_query($connection, "DELETE FROM b_turniertabelle WHERE turniere_id = '$turniere_id'");
                        mysqli_query($connection, "DELETE FROM b_turnierteams WHERE turniere_id = '$turniere_id'");
                        mysqli_query($connection, "DELETE FROM b_turniere WHERE turniere_id = '$turniere_id'");

                        header("Location: index.php");
                    else:
                        ?>
                        <div class="col-md-12">
                            <div class="box table-responsive">
                                <h2><?= getTurniernameVonTurniereID($turniere_id) ?> - Löschung</h2>
                                <form method="POST" action="">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td width="100%" align="center">Wollen Sie das Turnier wirklich
                                                löschen?
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <input name="turnier_id" type="hidden"
                                                       value="<?php echo $turniere_id; ?>">
                                                <button type="submit" name="submit_turnierentfernung"
                                                        class="btn btn-primary form-control">Turnier endgültig
                                                    löschen
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