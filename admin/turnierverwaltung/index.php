<?php
$pageKey  = 'turnierverwaltung';
$pageName = 'turnierverwaltung';

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

					// Turnierverwaltung Übersicht
					if ( $action == "" ):
						?>
                        <div class="col-md-12">
                            <div class="container clearfix">
                                <div class="box table-responsive">
                                    <h2>Turnierübersicht</h2>
                                    <table class="table table-bordered">
                                        <tr bgcolor="#E8E8E8">
											<td width="3%" align="left"><b>ID</b></td>
                                            <td width="15%" align="left"><b>Turniername</b></td>
                                            <td width="15%" align="left"><b>Turnierlocation</b></td>
                                            <td width="10%" align="center"><b>Turniermodus</b></td>
                                            <td width="10%" align="center"><b>Teilnehmer</b></td>
                                            <td width="10%" align="center"><b>Gruppen</b></td>
                                            <td width="10%" align="center"><b>Spielfelder</b></td>
                                            <td width="12%" align="center"><b>Turnierstart</b></td>
                                            <td width="10%" align="center"><b>Status</b></td>
                                        </tr>
										<?php
										$query = mysqli_query( $connection, "SELECT * FROM b_turniere WHERE beendet = '2'" );
										while ( $db = $query->fetch_object() ):
											?>
                                            <tr>
												<td align="left"><?= $db->turniere_id ?></td>
                                                <td align="left"><?= $db->turniername ?> - <?= $db->turnierort ?></td>
                                                <td align="left"><?= $db->turnierlocation ?></td>
                                                <td align="center">
													<?php
													if ( $db->turniermodus == 1 ):
														if ( $db->rueckspiel_gruppe == 1 ):
															echo "Gruppen - 2 Spiele";
														else:
															echo "Gruppen - 1 Spiel";
														endif;
                                                    elseif ( $db->turniermodus == 2 ):
														echo "KO-Runde";
													endif;
													?>
                                                </td>
                                                <td align="center"><?= $db->turnierteilnehmer ?></td>
                                                <td align="center"><?= $db->turniergruppen ?></td>
                                                <td align="center"><?= $db->turnierfelder ?></td>
                                                <td align="center"><?= date( "d.m.y - H:i", $db->turnierstart ) ?> Uhr</td>
                                                <td align="center">
<?php
													if($db->turnieranmeldung_gestartet == 1):
														echo "Anmeldung gestartet";
													elseif($db->turniercheckin_gestartet == 1):
														echo "Check-In gestartet";
													elseif($db->turniercheckin2_gestartet == 1):
														echo "Late Check-In gestartet";
													elseif($db->gestartet == 1):
														echo "Turnier gestartet";
													endif;
?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="100%" align="center" colspan="9">
													<?php
													// Gruppenphase
													if ( $db->turniermodus == 1 ):
														// Noch nicht gestartet
														if ( $db->gestartet == 2 ):
															?>
                                                            <form method="post" action="turnierstart.php">
                                                                <input name="turnier_id" type="hidden"
                                                                       value="<?php echo $db->turniere_id; ?>">
                                                                <button type="submit" class="btn btn-primary btn-round">
                                                                    Turnierstart
                                                                </button>
                                                            </form>
                                                            <form method="post" action="turnier-bearbeiten.php">
                                                                <input name="turnier_id" type="hidden"
                                                                       value="<?php echo $db->turniere_id; ?>">
                                                                <button type="submit" class="btn btn-primary btn-round">
                                                                    Turnier bearbeiten
                                                                </button>
                                                            </form>
														<?php
														endif;
														// Turnier gestartet, aber noch nicht beendet
														if ( $db->gestartet == 1 && $db->beendet == 2 ):
															// Keine offenen Spiele mehr
															if ( countOffeneSpieleVonTurniereID( $db->turniere_id ) == 0 ):
																?>
                                                                <form method="post" action="turnierauswertung.php">
                                                                    <input name="turnier_id" type="hidden"
                                                                           value="<?php echo $db->turniere_id; ?>">
                                                                    <button type="submit"
                                                                            class="btn btn-primary btn-round">K.O.-Runde
                                                                        auslosen
                                                                    </button>
                                                                </form>
															<?php
															endif;
															?>
                                                            <form method="post" action="spielwertung.php">
                                                                <input name="turnier_id" type="hidden"
                                                                       value="<?php echo $db->turniere_id; ?>">
                                                                <button type="submit" class="btn btn-primary btn-round">
                                                                    Spielwertung
                                                                </button>
                                                            </form>
															<a class="btn btn-primary btn-round" href="/scripts/turnierbereich/index.php?turnier=<?php echo $db->turniere_id; ?>&action=tabelle" target="_blank" >Spielplan</a>
                                                            <form method="post" action="teams-verschieben.php">
                                                                <input name="turnier_id" type="hidden"
                                                                       value="<?php echo $db->turniere_id; ?>">
                                                                <button type="submit" class="btn btn-primary btn-round">
                                                                    Teams verschieben
                                                                </button>
                                                            </form>
														<?php
														endif;
														// Turnier noch nicht beendet
														if ( $db->beendet == 2 ):
															?>
                                                            <form method="post" action="turnierteilnehmer.php">
                                                                <input name="turnier_id" type="hidden"
                                                                       value="<?php echo $db->turniere_id; ?>">
                                                                <button type="submit" class="btn btn-primary btn-round">
                                                                    Turnierteilnehmer
                                                                </button>
                                                            </form>
                                                            <form method="post" action="turnierende.php">
                                                                <input name="turnier_id" type="hidden"
                                                                       value="<?php echo $db->turniere_id; ?>">
                                                                <button type="submit" class="btn btn-primary btn-round">
                                                                    Turnierende
                                                                </button>
                                                            </form>

														<?php
														endif;

														?>
                                                        <form method="post" action="turnier-loeschen.php">
                                                            <input name="turnier_id" type="hidden"
                                                                   value="<?php echo $db->turniere_id; ?>">
                                                            <button type="submit" class="btn btn-primary btn-round">
                                                                Turnier löschen
                                                            </button>
                                                        </form>
													<?php

													// K.O. - Runde
                                                    elseif ( $db->turniermodus == 2 ):
														// Turnier noch nicht gestartet
														if ( $db->gestartet == 2 ):
															?>
                                                            <form method="post" action="turnierstart.php">
                                                                <input name="turnier_id" type="hidden"
                                                                       value="<?php echo $db->turniere_id; ?>">
                                                                <button type="submit" class="btn btn-primary btn-round">
                                                                    Turnierstart
                                                                </button>
                                                            </form>
                                                            <form method="post" action="turnier-bearbeiten.php">
                                                                <input name="turnier_id" type="hidden"
                                                                       value="<?php echo $db->turniere_id; ?>">
                                                                <button type="submit" class="btn btn-primary btn-round">
                                                                    Turnier bearbeiten
                                                                </button>
                                                            </form>
														<?php
														endif;
														// Turnier gestartet, aber noch nicht beendet
														if ( $db->gestartet == 1 && $db->beendet == 2 ):
															?>
                                                            <form method="post" action="spielwertung.php">
                                                                <input name="turnier_id" type="hidden"
                                                                       value="<?php echo $db->turniere_id; ?>">
                                                                <button type="submit" class="btn btn-primary btn-round">
                                                                    Spielwertung
                                                                </button>
                                                            </form>
                                                            <form method="post" action="teams-verschieben.php">
                                                                <input name="turnier_id" type="hidden"
                                                                       value="<?php echo $db->turniere_id; ?>">
                                                                <button type="submit" class="btn btn-primary btn-round">
                                                                    Teams verschieben
                                                                </button>
                                                            </form>
														<?php
														endif;
														// Alle Spiele gewertet, Turnier noch nicht beendet
														if ( $db->beendet == 2 ):
															?>
                                                            <form method="post" action="turnierteilnehmer.php">
                                                                <input name="turnier_id" type="hidden"
                                                                       value="<?php echo $db->turniere_id; ?>">
                                                                <button type="submit" class="btn btn-primary btn-round">
                                                                    Turnierteilnehmer
                                                                </button>
                                                            </form>
                                                            <form method="post" action="turnierende.php">
                                                                <input name="turnier_id" type="hidden"
                                                                       value="<?php echo $db->turniere_id; ?>">
                                                                <button type="submit" class="btn btn-primary btn-round">
                                                                    Turnierende
                                                                </button>
                                                            </form>
														<?php
														endif;

														// Turnier löschen
														?>
                                                        <form method="post" action="turnier-loeschen.php">
                                                            <input name="turnier_id" type="hidden"
                                                                   value="<?php echo $db->turniere_id; ?>">
                                                            <button type="submit" class="btn btn-primary btn-round">
                                                                Turnier löschen
                                                            </button>
                                                        </form>

                                                        <?php
                                                        //Online-Turnier
                                                        if ( $db->online == 1 ) {
                                                            if( $db->zeige_in_dashboard == '0' ) {
                                                                ?>
                                                                <form method="POST" action="online-turnier.php">
                                                                    <input name="action" type="hidden"
                                                                           value="zeige_in_dashboard">
                                                                    <input name="turnier_id" type="hidden"
                                                                           value="<?php echo $db->turniere_id; ?>">
                                                                    <button type="submit" class="btn btn-primary btn-round">
                                                                        Zeige in Dashboard
                                                                    </button>
                                                                </form>
                                                                <?php
                                                            }
                                                            switch($db->turnieranmeldung_gestartet) {
                                                                case '0' :
                                                                    // Anmeldung nicht gestartet
                                                                    ?>
                                                                    <form method="POST" action="online-turnier.php">
                                                                        <input name="action" type="hidden"
                                                                               value="anmeldephase_starten">
                                                                        <input name="turnier_id" type="hidden"
                                                                               value="<?php echo $db->turniere_id; ?>">
                                                                        <button type="submit" class="btn btn-primary btn-round">
                                                                            Anmeldephase starten
                                                                        </button>
                                                                    </form>
                                                                    <?php
                                                                    break;
                                                                case '1' :
                                                                    // Anmeldephase gestartet
                                                                    ?>
                                                                    <form method="POST" action="online-turnier.php">
                                                                        <input name="action" type="hidden"
                                                                               value="anmeldephase_beenden">
                                                                        <input name="turnier_id" type="hidden"
                                                                               value="<?php echo $db->turniere_id; ?>">
                                                                        <button type="submit" class="btn btn-primary btn-round">
                                                                            Anmeldephase beenden
                                                                        </button>
                                                                    </form>
                                                                    <?php
                                                                    break;
                                                                case '2' :
                                                                    // Anmeldephase beendet
                                                                    ?>

                                                                    <?php
                                                                    break;
                                                            }
                                                            if($db->turnieranmeldung_gestartet == "2") {
                                                                switch ($db->turniercheckin_gestartet) {
                                                                    case '0' :
                                                                        // CheckIn nicht gestartet
                                                                        ?>
                                                                        <form method="POST" action="online-turnier.php">
                                                                            <input name="action" type="hidden"
                                                                                   value="checkin_starten">
                                                                            <input name="turnier_id" type="hidden"
                                                                                   value="<?php echo $db->turniere_id; ?>">
                                                                            <button type="submit"
                                                                                    class="btn btn-primary btn-round">
                                                                                Check-In starten
                                                                            </button>
                                                                        </form>
                                                                        <?php
                                                                        break;
                                                                    case '1' :
                                                                        // CheckIn gestartet
                                                                        ?>
                                                                        <form method="POST" action="online-turnier.php">
                                                                            <input name="action" type="hidden"
                                                                                   value="checkin_beenden">
                                                                            <input name="turnier_id" type="hidden"
                                                                                   value="<?php echo $db->turniere_id; ?>">
                                                                            <button type="submit"
                                                                                    class="btn btn-primary btn-round">
                                                                                Check-In beenden
                                                                            </button>
                                                                        </form>
                                                                        <?php
                                                                        break;
                                                                    case '2' :
                                                                        // CheckIn beendet
                                                                        ?>

                                                                        <?php
                                                                        break;
                                                                }
                                                            }
                                                            if($db->turniercheckin_gestartet == "2") {
                                                                switch ($db->turniercheckin2_gestartet) {
                                                                    case '0' :
                                                                        // CheckIn2 nicht gestartet
                                                                        ?>
                                                                        <form method="POST" action="online-turnier.php">
                                                                            <input name="action" type="hidden"
                                                                                   value="checkin2_starten">
                                                                            <input name="turnier_id" type="hidden"
                                                                                   value="<?php echo $db->turniere_id; ?>">
                                                                            <button type="submit"
                                                                                    class="btn btn-primary btn-round">
                                                                                Late-Check-In starten
                                                                            </button>
                                                                        </form>
                                                                        <?php
                                                                        break;
                                                                    case '1' :
                                                                        // CheckIn2 gestartet
                                                                        ?>
                                                                        <form method="POST" action="online-turnier.php">
                                                                            <input name="action" type="hidden"
                                                                                   value="checkin2_beenden">
                                                                            <input name="turnier_id" type="hidden"
                                                                                   value="<?php echo $db->turniere_id; ?>">
                                                                            <button type="submit"
                                                                                    class="btn btn-primary btn-round">
                                                                                Late-Check-In beenden
                                                                            </button>
                                                                        </form>
                                                                        <?php
                                                                        break;
                                                                    case '2' :
                                                                        // CheckIn2 beendet
                                                                        ?>

                                                                        <?php
                                                                        break;
                                                                }
                                                            }

                                                        }

                                                        ?>
													<?php
													endif;
													?>
                                                </td>
                                            </tr>
										<?php
										endwhile;
										?>
                                    </table>
                                </div>
                            </div>
                        </div>
					<?php

					// ENDE Turnierübersicht



						/*
						 * Wird nicht mehr gebraucht
						 *
					elseif ($action == "turnierauslosung"):
						$turniere_id = mysqli_real_escape_string($connection, $_GET["turnier"]);

						$query_turnier = mysqli_query($connection, "SELECT * FROM b_turniere WHERE turniere_id = '$turniere_id'");
						$db_turnier = $query_turnier->fetch_object();

						if (countOffeneRundenspieleVonTurniereID($turniere_id, getTurnierrundeVonTurniereID($turniere_id)) == 0):
							$runde_akt = getTurnierrundeVonTurniereID($turniere_id);
							$runde_neu = $runde_akt + 1;
							$runde_finale = $runde_akt + 2;
							$teilnehmer_aktuell = getTurnierrundenteilnehmerVonTurniereID($turniere_id, $runde_akt);

							if (getTurnierrundenteilnehmerVonTurniereID($turniere_id, $runde_neu) >= 2):
								### wenn Halbfinale ###
								if ($runde_neu == getTurnierrundenVonTurniereID($turniere_id)):
									$query = mysqli_query($connection, "SELECT * FROM b_spiele WHERE turniere_id = '$turniere_id' AND spieltag = '$runde_akt' ORDER BY spiele_id ASC");
									while ($db = $query->fetch_object()):
										if ($db->tore_heim > $db->tore_gast):
											$teams_f[] = $db->team_heim;
											$teams_s3[] = $db->team_gast;
										elseif ($db->tore_heim < $db->tore_gast):
											$teams_f[] = $db->team_gast;
											$teams_s3[] = $db->team_heim;
										endif;
									endwhile;

									### Spiel um Platz 3 ###
									$query = mysqli_query($connection, "SELECT * FROM b_spiele WHERE turniere_id = '$turniere_id' AND spieltag = '$runde_neu' ORDER BY spiele_id ASC");
									while ($db = $query->fetch_object()):
										$datum = $time;

										mysqli_query($connection, "UPDATE b_spiele SET team_heim = '" . $teams_s3[0] . "', team_gast = '" . $teams_s3[1] . "', spielort = 'TV 1', datum = '$datum' WHERE spiele_id = '$db->spiele_id'");
									endwhile;

									### Finale ###
									$query = mysqli_query($connection, "SELECT * FROM b_spiele WHERE turniere_id = '$turniere_id' AND spieltag = '$runde_finale' ORDER BY spiele_id ASC");
									while ($db = $query->fetch_object()):
										$datum = $time + ($db_turnier->turnierspielzeit * 60);

										mysqli_query($connection, "UPDATE b_spiele SET team_heim = '" . $teams_f[0] . "', team_gast = '" . $teams_f[1] . "', spielort = 'TV 1', datum = '$datum' WHERE spiele_id = '$db->spiele_id'");
									endwhile;

									mysqli_query($connection, "UPDATE b_turniere SET turnierrunde = turnierrunde + 1 WHERE turniere_id = '$turniere_id'");
								### alles vor Halbfinale ###
								else:
									$spielnr = 1;
									$query = mysqli_query($connection, "SELECT * FROM b_spiele WHERE turniere_id = '$turniere_id' AND spieltag = '$runde_akt' ORDER BY spiele_id ASC");
									while ($db = $query->fetch_object()):
										if ($spielnr % 2 == 0):
											if ($db->tore_heim > $db->tore_gast):
												$teams_gast[] = $db->team_heim;

												mysqli_query($connection, "UPDATE b_turnierteams SET beendet = '1' WHERE turniere_id = '$turniere_id' AND team_id = '$db->team_gast'");
											elseif ($db->tore_heim < $db->tore_gast):
												$teams_gast[] = $db->team_gast;

												mysqli_query($connection, "UPDATE b_turnierteams SET beendet = '1' WHERE turniere_id = '$turniere_id' AND team_id = '$db->team_heim'");
											endif;
										else:
											if ($db->tore_heim > $db->tore_gast):
												$teams_heim[] = $db->team_heim;

												mysqli_query($connection, "UPDATE b_turnierteams SET beendet = '1' WHERE turniere_id = '$turniere_id' AND team_id = '$db->team_gast'");
											elseif ($db->tore_heim < $db->tore_gast):
												$teams_heim[] = $db->team_gast;

												mysqli_query($connection, "UPDATE b_turnierteams SET beendet = '1' WHERE turniere_id = '$turniere_id' AND team_id = '$db->team_heim'");
											endif;
										endif;

										$spielnr++;
									endwhile;

									$spielnr = 0;
									$spielenr = 1;
									$tvnr = 0;

									$query = mysqli_query($connection, "SELECT * FROM b_spiele WHERE turniere_id = '$turniere_id' AND spieltag = '$runde_neu' ORDER BY spiele_id ASC");
									while ($db = $query->fetch_object()):
										$tvnr++;
										$spielort = "TV " . $tvnr;

										if ($spielnr < $db_turnier->turnierfelder):
											$datum = $time;
										else:
											if ($spielnr % $db_turnier->turnierfelder == 0):
												$datum += ($db_turnier->turnierspielzeit * 60);
											endif;
										endif;

										mysqli_query($connection, "UPDATE b_spiele SET team_heim = '" . $teams_heim[$spielnr] . "', team_gast = '" . $teams_gast[$spielnr] . "', spielort = '$spielort', datum = '$datum' WHERE spiele_id = '$db->spiele_id'");

										$spielnr++;
										$spielenr++;

										if ($tvnr == $db_turnier->turnierfelder):
											$tvnr = 0;
										endif;
									endwhile;

									mysqli_query($connection, "UPDATE b_turniere SET turnierrunde = turnierrunde + 1 WHERE turniere_id = '$turniere_id'");
								endif;
							endif;
						endif;

						header("Location: index.php");
*/


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