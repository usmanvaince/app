<?php
$pageKey         = 'user_dashboard';

include( "../../functions/functions.php" );
require_once "../../templates/header.php";

/*
---------------------------------------------------------
| © 2016 FIFA Turniere // Bayreuther Jungs e.V.				|
| E-Mail: info@fifa-turniere.de							|
---------------------------------------------------------
*/
session_start();

if ( ! isset( $_SESSION["user_id"] ) ):
	header( "Location: ../../index.php?info=8" );
elseif ( $_SESSION["user_status"] != "admin" ):
	header( "Location: ../../index.php?info=9" );
else:
	$action = mysqli_real_escape_string( $connection, $_GET["action"] );
	$turniere_id = $_POST['turnier_id'];
	var_dump( $turniere_id );

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


						if ( isset( $_POST["submit_turnierteamverschiebung"] ) ):
							$team_id1    = mysqli_real_escape_string( $connection, $_POST["team_id1"] );
							$team_id2    = mysqli_real_escape_string( $connection, $_POST["team_id2"] );
							$turniere_id = $_POST['turnier_id'];

							if ( $team_id1 == $team_id2 ):

							else:
								### b_spiele ###
								mysqli_query( $connection, "UPDATE b_spiele SET team_heim = '9998' WHERE turniere_id = '$turniere_id' AND team_heim = '$team_id1'" );
								mysqli_query( $connection, "UPDATE b_spiele SET team_gast = '9998' WHERE turniere_id = '$turniere_id' AND team_gast = '$team_id1'" );
								mysqli_query( $connection, "UPDATE b_spiele SET team_heim = '9999' WHERE turniere_id = '$turniere_id' AND team_heim = '$team_id2'" );
								mysqli_query( $connection, "UPDATE b_spiele SET team_gast = '9999' WHERE turniere_id = '$turniere_id' AND team_gast = '$team_id2'" );

								mysqli_query( $connection, "UPDATE b_spiele SET team_heim = '$team_id2' WHERE turniere_id = '$turniere_id' AND team_heim = '9998'" );
								mysqli_query( $connection, "UPDATE b_spiele SET team_gast = '$team_id2' WHERE turniere_id = '$turniere_id' AND team_gast = '9998'" );
								mysqli_query( $connection, "UPDATE b_spiele SET team_heim = '$team_id1' WHERE turniere_id = '$turniere_id' AND team_heim = '9999'" );
								mysqli_query( $connection, "UPDATE b_spiele SET team_gast = '$team_id1' WHERE turniere_id = '$turniere_id' AND team_gast = '9999'" );

								### b_turniertabelle ###
								/*mysqli_query( $connection, "UPDATE b_turniertabelle SET team_id = '9998' WHERE turniere_id = '$turniere_id' AND team_id = '$team_id1'" );
								mysqli_query( $connection, "UPDATE b_turniertabelle SET team_id = '9999' WHERE turniere_id = '$turniere_id' AND team_id = '$team_id2'" );

								mysqli_query( $connection, "UPDATE b_turniertabelle SET team_id = '$team_id2' WHERE turniere_id = '$turniere_id' AND team_id = '9998'" );
								mysqli_query( $connection, "UPDATE b_turniertabelle SET team_id = '$team_id1' WHERE turniere_id = '$turniere_id' AND team_id = '9999'" );*/



								### b_turniertabelle ###
								mysqli_query($connection, "UPDATE b_turniertabelle SET team_id = '9998' WHERE turniere_id = '$turniere_id' AND team_id = '$team_id1'");
								mysqli_query($connection, "UPDATE b_turniertabelle SET team_id = '9999' WHERE turniere_id = '$turniere_id' AND team_id = '$team_id2'");

								mysqli_query($connection, "UPDATE b_turniertabelle SET team_id = '$team_id1' WHERE turniere_id = '$turniere_id' AND team_id = '9999'");
								mysqli_query($connection, "UPDATE b_turniertabelle SET team_id = '$team_id2' WHERE turniere_id = '$turniere_id' AND team_id = '9998'");


							endif;
						endif;
						?>
                            <form method="POST" action="">
                                <div class="col-md-6">
                                    <h2>1. Team</h2>
                                    <select name="team_id1" data-size="150" title="wählen">
										<?php
										$query = mysqli_query( $connection, "SELECT team_id, team FROM b_turnierteams WHERE turniere_id = '$turniere_id' ORDER BY team ASC" );
										while ( $db = $query->fetch_object() ):
											echo "<option value='$db->team_id'>" . $db->team . "</option>";
										endwhile;
										?>
                                    </select>
                                </div>

                        <div class="col-md-6">
                            <h2>2. Team</h2>
                            <select name="team_id2" data-size="150" title="wählen">
								<?php
								$query = mysqli_query( $connection, "SELECT team_id, team FROM b_turnierteams WHERE turniere_id = '$turniere_id' ORDER BY team ASC" );
								while ( $db = $query->fetch_object() ):
									echo "<option value='$db->team_id'>" . $db->team . "</option>";
								endwhile;
								?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <input type="hidden" name="turnier_id"
                               value="<?= $turniere_id ?>"/>
                        <button type="submit" name="submit_turnierteamverschiebung"
                                class="btn btn-primary form-control">Teams verschieben
                        </button>
                    </div>
                </div>
                </form>
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