<?php
/*
---------------------------------------------------------
| Erstellt von Niko Otte-Krone							|
| E-Mail: N.Otte-Krone@gmx.de							|
---------------------------------------------------------
*/

function countOffeneSpieleVonTurniereID( $turniere_id ) {
	global $connection;
	$anzahl = mysqli_num_rows( mysqli_query( $connection, "SELECT * FROM b_spiele WHERE turniere_id = '$turniere_id' AND status = '1'" ) );

	return $anzahl;
}

function countOffeneRundenspieleVonTurniereID( $turniere_id, $spieltag ) {
	global $connection;
	$anzahl = mysqli_num_rows( mysqli_query( $connection, "SELECT * FROM b_spiele WHERE turniere_id = '$turniere_id' AND spieltag = '$spieltag' AND status = '1'" ) );

	return $anzahl;
}

function countGruppenVonTurniereID( $turniere_id ) {
	global $connection;
	$query = mysqli_query( $connection, "SELECT MAX(gruppe) AS anzGruppen FROM b_spiele WHERE turniere_id = '$turniere_id'" );
	$db    = $query->fetch_object();

	return $db->anzGruppen;
}

function getTurniernameVonTurniereID( $turniere_id ) {
	global $connection;
	$query = mysqli_query( $connection, "SELECT turniername FROM b_turniere WHERE turniere_id = '$turniere_id'" );
	$db    = $query->fetch_object();

	return $db->turniername;
}

function getTurnierortVonTurniereID( $turniere_id ) {
	global $connection;
	$query = mysqli_query( $connection, "SELECT turnierort FROM b_turniere WHERE turniere_id = '$turniere_id'" );
	$db    = $query->fetch_object();

	return $db->turnierort;
}

function getTurnierteilnehmerVonTurniereID( $turniere_id ) {
	global $connection;
	$query = mysqli_query( $connection, "SELECT turnierteilnehmer FROM b_turniere WHERE turniere_id = '$turniere_id'" );
	$db    = $query->fetch_object();

	return $db->turnierteilnehmer;
}

function getTurnieranmeldungVonTurniereID( $turniere_id ) {
	global $connection;
	$query = mysqli_query( $connection, "SELECT turnieranmeldung FROM b_turniere WHERE turniere_id = '$turniere_id'" );
	$db    = $query->fetch_object();

	return $db->turnieranmeldung;
}

function getTurniercheckinVonTurniereID( $turniere_id ) {
	global $connection;
	$query = mysqli_query( $connection, "SELECT turniercheckin FROM b_turniere WHERE turniere_id = '$turniere_id'" );
	$db    = $query->fetch_object();

	return $db->turniercheckin;
}

function getTurniercheckin2VonTurniereID( $turniere_id ) {
	global $connection;
	$query = mysqli_query( $connection, "SELECT turniercheckin2 FROM b_turniere WHERE turniere_id = '$turniere_id'" );
	$db    = $query->fetch_object();

	return $db->turniercheckin2;
}

function getTurnierstartVonTurniereID( $turniere_id ) {
	global $connection;
	$query = mysqli_query( $connection, "SELECT turnierstart FROM b_turniere WHERE turniere_id = '$turniere_id'" );
	$db    = $query->fetch_object();

	return $db->turnierstart;
}

function getTurnierteamVonTurnierteamID( $turniere_id, $turnierteam_id ) {
	global $connection;
	$query = mysqli_query( $connection, "SELECT team FROM b_turnierteams WHERE turniere_id = '$turniere_id' AND team_id = '$turnierteam_id'" );
	$db    = $query->fetch_object();

	return $db->team;
}

function getTurniergruppenphaseIDVonTurniereID( $turniere_id ) {
	global $connection;
	$query = mysqli_query( $connection, "SELECT turniergruppenphase_id FROM b_turniere WHERE turniere_id = '$turniere_id'" );
	$db    = $query->fetch_object();

	if ( $db->turniergruppenphase_id == "" ):
		$turniergruppenphase_id = $turniere_id;
	else:
		$turniergruppenphase_id = $db->turniergruppenphase_id;
	endif;

	return $turniergruppenphase_id;
}

function getTurniermodusIDVonTurniereID( $turniere_id ) {
	global $connection;
	$query = mysqli_query( $connection, "SELECT turniermodus FROM b_turniere WHERE turniere_id = '$turniere_id'" );
	$db    = $query->fetch_object();

	return $db->turniermodus;
}

function getTurniermodusNameVonTurniereID( $turniere_id ) {
	global $connection;
	$query = mysqli_query( $connection, "SELECT turniermodus, rueckspiel_gruppe FROM b_turniere WHERE turniere_id = '$turniere_id'" );
	$db    = $query->fetch_object();

	if ( $db->turniermodus == 1 ):
		if ( $db->rueckspiel_gruppe == 1 ):
			$turniermodus = "Gruppenphase mit Rückspiel";
		else:
			$turniermodus = "Gruppenphase ohne Rückspiel";
		endif;
	elseif ( $db->turniermodus == 2 ):
		$turniermodus = "KO-Runde";
	endif;

	return $turniermodus;
}

function getTurnierrundeVonTurniereID( $turniere_id ) {
	global $connection;
	$query = mysqli_query( $connection, "SELECT turnierrunde FROM b_turniere WHERE turniere_id = '$turniere_id'" );
	$db    = $query->fetch_object();

	return $db->turnierrunde;
}

function getTurnierrundenVonTurniereID( $turniere_id ) {
	global $connection;
	$query = mysqli_query( $connection, "SELECT turnierteilnehmer FROM b_turniere WHERE turniere_id = '$turniere_id'" );
	$db    = $query->fetch_object();

	if ( $db->turnierteilnehmer == 2 ):
		$turnierrunden = 1;
	elseif ( $db->turnierteilnehmer == 4 ):
		$turnierrunden = 2;
	elseif ( $db->turnierteilnehmer == 8 ):
		$turnierrunden = 3;
	elseif ( $db->turnierteilnehmer == 16 ):
		$turnierrunden = 4;
	elseif ( $db->turnierteilnehmer == 32 ):
		$turnierrunden = 5;
	elseif ( $db->turnierteilnehmer == 64 ):
		$turnierrunden = 6;
	elseif ( $db->turnierteilnehmer == 128 ):
		$turnierrunden = 7;
	elseif ( $db->turnierteilnehmer == 256 ):
		$turnierrunden = 8;
	elseif ( $db->turnierteilnehmer == 512 ):
		$turnierrunden = 9;
	endif;

	return $turnierrunden;
}

function getTurnierrundenteilnehmerVonTurniereID( $turniere_id, $runde ) {
	global $connection;
	$query = mysqli_query( $connection, "SELECT COUNT(*) AS anzSpiele FROM b_spiele WHERE turniere_id = '$turniere_id' AND spieltag = '$runde'" );
	$db    = $query->fetch_object();

	$anzahl = $db->anzSpiele * 2;

	return $anzahl;
}

function getTurnierrundenname( $turnierrundenteilnehmer, $turniere_id, $runde ) {
	global $connection;

	if ( $turnierrundenteilnehmer == 2 ):
		if ( $runde == getTurnierrundenVonTurniereID( $turniere_id ) + 1 ):
			$runde = "Finale";
		else:
			$runde = "Spiel um Platz 3";
		endif;
	elseif ( $turnierrundenteilnehmer == 4 ):
		$runde = "Halbfinale";
	elseif ( $turnierrundenteilnehmer == 8 ):
		$runde = "Viertelfinale";
	elseif ( $turnierrundenteilnehmer == 16 ):
		$runde = "Achtelfinale";
	elseif ( $turnierrundenteilnehmer == 32 ):
		switch($runde) {
			case '1':
				$runde = 'Runde 1';
				break;
			case '2':
				$runde = 'Runde 2';
				break;
			case '3':
				$runde = 'Runde 3';
				break;
			case '4':
				$runde = 'Runde 4';
				break;
			case '5':
				$runde = 'Runde 5';
				break;
		}
	elseif ( $turnierrundenteilnehmer == 64 ):
		switch($runde) {
			case '1':
				$runde = 'Runde 1';
				break;
			case '2':
				$runde = 'Runde 2';
				break;
			case '3':
				$runde = 'Runde 3';
				break;
			case '4':
				$runde = 'Runde 4';
				break;
			case '5':
				$runde = 'Runde 5';
				break;
		}
	elseif ( $turnierrundenteilnehmer == 128 ):
		switch($runde) {
			case '1':
				$runde = 'Runde 1';
				break;
			case '2':
				$runde = 'Runde 2';
				break;
			case '3':
				$runde = 'Runde 3';
				break;
			case '4':
				$runde = 'Runde 4';
				break;
			case '5':
				$runde = 'Runde 5';
				break;
		}
	elseif ( $turnierrundenteilnehmer == 256 ):
		switch($runde) {
			case '1':
				$runde = 'Runde 1';
				break;
			case '2':
				$runde = 'Runde 2';
				break;
			case '3':
				$runde = 'Runde 3';
				break;
			case '4':
				$runde = 'Runde 4';
				break;
			case '5':
				$runde = 'Runde 5';
				break;
		}
	elseif ( $turnierrundenteilnehmer == 512 ):
		switch($runde) {
			case '1':
				$runde = 'Runde 1';
				break;
			case '2':
				$runde = 'Runde 2';
				break;
			case '3':
				$runde = 'Runde 3';
				break;
			case '4':
				$runde = 'Runde 4';
				break;
			case '5':
				$runde = 'Runde 5';
				break;
		}
	endif;

	return $runde;
}

function getShortTurnierrundenname( $turnierrundenteilnehmer, $turniere_id, $runde ) {
	global $connection;

	if ( $turnierrundenteilnehmer == 2 ):
		if ( $runde == getTurnierrundenVonTurniereID( $turniere_id ) + 1 ):
			$runde = "F";
		else:
			$runde = "S3";
		endif;
	elseif ( $turnierrundenteilnehmer == 4 ):
		$runde = "HF";
	elseif ( $turnierrundenteilnehmer == 8 ):
		$runde = "VF";
	elseif ( $turnierrundenteilnehmer == 16 ):
		$runde = "AF";
	elseif ( $turnierrundenteilnehmer == 32 ):
		$runde = "SF";
	elseif ( $turnierrundenteilnehmer == 64 ):
		$runde = "R2";
	elseif ( $turnierrundenteilnehmer == 128 ):
		$runde = "R1";
	elseif ( $turnierrundenteilnehmer == 256 ):
		$runde = "GRP";
	elseif ( $turnierrundenteilnehmer == 512 ):
		$runde = "GRP";
	endif;

	return $runde;
}


function ErstelleBracketVonTurniereID( $turniere_id ) {
	global $connection;
	$query_turnier = mysqli_query( $connection, "SELECT turnierteilnehmer, turnierfelder FROM b_turniere WHERE turniere_id = '$turniere_id'" );
	$db_turnier    = $query_turnier->fetch_object();

	if ( $db_turnier->turnierteilnehmer == 2 ) {
		$turnierrunden = 1;
	} elseif ( $db_turnier->turnierteilnehmer == 4 ) {
		$turnierrunden = 2;
	} elseif ( $db_turnier->turnierteilnehmer == 8 ) {
		$turnierrunden = 3;
	} elseif ( $db_turnier->turnierteilnehmer == 16 ) {
		$turnierrunden = 4;
	} elseif ( $db_turnier->turnierteilnehmer == 32 ) {
		$turnierrunden = 5;
	} elseif ( $db_turnier->turnierteilnehmer == 64 ) {
		$turnierrunden = 6;
	} elseif ( $db_turnier->turnierteilnehmer == 128 ) {
		$turnierrunden = 7;
	} elseif ( $db_turnier->turnierteilnehmer == 256 ) {
		$turnierrunden = 8;
	} elseif ( $db_turnier->turnierteilnehmer == 512 ) {
		$turnierrunden = 9;
	}

	$turnierteilnehmer = $db_turnier->turnierteilnehmer;

	// Erstellt für sämtliche Speiulrunden den Turnierbaum, sprich die Spiele ohne engetragene Teilnehmer
	for ( $i = 1; $i <= $turnierrunden; $i ++ ) {

		$anz_spiele = $turnierteilnehmer / 2;

		// Finalrunde
		if ( $i == $turnierrunden ) {
			### Spiel um Platz 3 ###
			mysqli_query( $connection, "INSERT INTO b_spiele (status, turniere_id, spieltag) VALUES ('1', '$turniere_id', '$i')" );

			### Finale ###
			$spielrunde = $i + 1;
			mysqli_query( $connection, "INSERT INTO b_spiele (status, turniere_id, spieltag) VALUES ('1', '$turniere_id', '$spielrunde')" );
		}
		else {
			for ( $spiel = 1; $spiel <= $anz_spiele; $spiel ++ ) {
				mysqli_query( $connection, "INSERT INTO b_spiele (status, turniere_id, spieltag) VALUES ('1', '$turniere_id', '$i')" );
			}
		}
		$turnierteilnehmer -= $anz_spiele;
	}


	$query = mysqli_query( $connection, "SELECT * FROM s_spielbelegung WHERE teilnehmer = '$db_turnier->turnierteilnehmer'" );
	while ( $db = $query->fetch_object() ) {
		$arSB[ $db->spiel_akt ]["next"] = $db->spiel_next;
	}


	$i     = 1;
	$query = mysqli_query( $connection, "SELECT * FROM b_spiele WHERE turniere_id = '$turniere_id' ORDER BY spiele_id ASC" );

	while ( $db = $query->fetch_object() ) {
		mysqli_query( $connection, "UPDATE b_spiele SET spiele_id_next = '" . $arSB[ $i ]["next"] . "', turnierspiele_id = '$i' WHERE spiele_id = '$db->spiele_id'" );
		$i ++;
	}


	$query_check = mysqli_query( $connection, "SELECT MAX(spieltag) AS maxSpieltag FROM b_spiele WHERE turniere_id = '$turniere_id'" );
	$db_check    = $query_check->fetch_object();

	for ( $spieltag = 2; $spieltag <= $db_check->maxSpieltag; $spieltag ++ ) {
		$tvnr = 0;

		$query = mysqli_query( $connection, "SELECT * FROM b_spiele WHERE turniere_id = '$turniere_id' AND spieltag = '$spieltag' ORDER BY spiele_id ASC" );
		while ( $db = $query->fetch_object() ) {
			$tvnr ++;
			$spielort = "TV " . $tvnr;

			mysqli_query( $connection, "UPDATE b_spiele SET spielort = '$spielort' WHERE spiele_id = '$db->spiele_id'" );

			if ( $tvnr == $db_turnier->turnierfelder ) {
				$tvnr = 0;
			}
		}
	}


}


function checkBelegungVonTurnierspieleID( $turniere_id, $turnierspiele_id ) {
	global $connection;
	$query = mysqli_query( $connection, "SELECT team_heim, team_gast FROM b_spiele WHERE turniere_id = '$turniere_id' AND turnierspiele_id = '$turnierspiele_id'" );
	$db    = $query->fetch_object();

	if ( isset( $db->team_heim ) || isset( $db->team_gast ) ):
		$belegt = 1;
	else:
		$belegt = 0;
	endif;

	return $belegt;
}

function getTurnierphaseVonTurniereID( $turniere_id, $datum ) {
	global $connection;
	$query = mysqli_query( $connection, "SELECT turnieranmeldung, turniercheckin, turnierstart FROM b_turniere WHERE turniere_id = '$turniere_id'" );
	$db    = $query->fetch_object();

	if ( $datum < $db->turnieranmeldung ):
		$phase = "Geschlossen";
	elseif ( $datum >= $db->turnieranmeldung && $datum < $db->turniercheckin ):
		$phase = "Registrierung";
	elseif ( $datum >= $db->turniercheckin && $datum < $db->turnierstart ):
		$phase = "Check-In";
	elseif ( $datum >= $db->turnierstart ):
		$phase = "Läuft";
	else:
		$phase = "-";
	endif;

	return $phase;
}

function checkUseranmeldungVonTurniereID( $turniere_id, $user ) {
	global $connection;
	$anzahl = mysqli_num_rows( mysqli_query( $connection, "SELECT * FROM b_turnierteams WHERE turniere_id = '$turniere_id' AND team = '$user'" ) );

	return $anzahl;
}

function countAnmeldungenVonTurniereID( $turniere_id ) {
	global $connection;
	$anzahl = mysqli_num_rows( mysqli_query( $connection, "SELECT * FROM b_turnierteams WHERE turniere_id = '$turniere_id' AND team NOT LIKE 'Team%'" ) );

	return $anzahl;
}

function getUserCheckInStatusVonTurniereID( $turniere_id, $user ) {
	global $connection;
	$anzahl = mysqli_num_rows( mysqli_query( $connection, "SELECT * FROM b_turnierteams WHERE turniere_id = '$turniere_id' AND team = '$user'" ) );

	if ( $anzahl == 0 ):
		$status = 2;
	else:
		$query = mysqli_query( $connection, "SELECT * FROM b_turnierteams WHERE turniere_id = '$turniere_id' AND team = '$user'" );
		$db    = $query->fetch_object();

		if ( $db->confirmed == 1 ):
			$status = 1;
		else:
			$status = 2;
		endif;
	endif;

	return $status;
}

function countCheckInsVonTurniereID( $turniere_id ) {
	global $connection;
	$anzahl = mysqli_num_rows( mysqli_query( $connection, "SELECT * FROM b_turnierteams WHERE turniere_id = '$turniere_id' AND team NOT LIKE 'Team%' AND confirmed = '1'" ) );

	return $anzahl;
}

function getTurniergruppentabelleVonWettbewerbeID( $turniere_id, $gruppe ) {
	global $connection;
	$query = mysqli_query( $connection, "SELECT status, spieltag, team_heim, team_gast, tore_heim, tore_gast FROM b_spiele WHERE turniere_id = '$turniere_id' AND gruppe = '$gruppe'" );
	while ( $db = $query->fetch_object() ):
		$arTeam[ $db->team_heim ]["teamid"] = $db->team_heim;
		$arTeam[ $db->team_gast ]["teamid"] = $db->team_gast;

		if ( $db->status == 2 ):
			if ( $db->tore_heim > $db->tore_gast ):
				$arTeam[ $db->team_heim ]["spiele"] ++;
				$arTeam[ $db->team_heim ]["siege"] ++;
				$arTeam[ $db->team_heim ]["tore"]      = $arTeam[ $db->team_heim ]["tore"] + $db->tore_heim;
				$arTeam[ $db->team_heim ]["gegentore"] = $arTeam[ $db->team_heim ]["gegentore"] + $db->tore_gast;
				$arTeam[ $db->team_heim ]["punkte"]    = $arTeam[ $db->team_heim ]["punkte"] + 3;

				$arTeam[ $db->team_gast ]["spiele"] ++;
				$arTeam[ $db->team_gast ]["niederlagen"] ++;
				$arTeam[ $db->team_gast ]["tore"]      = $arTeam[ $db->team_gast ]["tore"] + $db->tore_gast;
				$arTeam[ $db->team_gast ]["gegentore"] = $arTeam[ $db->team_gast ]["gegentore"] + $db->tore_heim;
			elseif ( $db->tore_heim == $db->tore_gast ):
				$arTeam[ $db->team_heim ]["spiele"] ++;
				$arTeam[ $db->team_heim ]["unentschieden"] ++;
				$arTeam[ $db->team_heim ]["tore"]      = $arTeam[ $db->team_heim ]["tore"] + $db->tore_heim;
				$arTeam[ $db->team_heim ]["gegentore"] = $arTeam[ $db->team_heim ]["gegentore"] + $db->tore_gast;
				$arTeam[ $db->team_heim ]["punkte"]    = $arTeam[ $db->team_heim ]["punkte"] + 1;

				$arTeam[ $db->team_gast ]["spiele"] ++;
				$arTeam[ $db->team_gast ]["unentschieden"] ++;
				$arTeam[ $db->team_gast ]["tore"]      = $arTeam[ $db->team_gast ]["tore"] + $db->tore_gast;
				$arTeam[ $db->team_gast ]["gegentore"] = $arTeam[ $db->team_gast ]["gegentore"] + $db->tore_heim;
				$arTeam[ $db->team_gast ]["punkte"]    = $arTeam[ $db->team_gast ]["punkte"] + 1;
			elseif ( $db->tore_heim < $db->tore_gast ):
				$arTeam[ $db->team_heim ]["spiele"] ++;
				$arTeam[ $db->team_heim ]["niederlagen"] ++;
				$arTeam[ $db->team_heim ]["tore"]      = $arTeam[ $db->team_heim ]["tore"] + $db->tore_heim;
				$arTeam[ $db->team_heim ]["gegentore"] = $arTeam[ $db->team_heim ]["gegentore"] + $db->tore_gast;

				$arTeam[ $db->team_gast ]["spiele"] ++;
				$arTeam[ $db->team_gast ]["siege"] ++;
				$arTeam[ $db->team_gast ]["tore"]      = $arTeam[ $db->team_gast ]["tore"] + $db->tore_gast;
				$arTeam[ $db->team_gast ]["gegentore"] = $arTeam[ $db->team_gast ]["gegentore"] + $db->tore_heim;
				$arTeam[ $db->team_gast ]["punkte"]    = $arTeam[ $db->team_gast ]["punkte"] + 3;
			endif;
		endif;
	endwhile;

	foreach ( $arTeam AS $team_id => $key ):
		$teamid[ $team_id ]        = $key["teamid"];
		$spiele[ $team_id ]        = $key["spiele"];
		$siege[ $team_id ]         = $key["siege"];
		$unentschieden[ $team_id ] = $key["unentschieden"];
		$niederlagen[ $team_id ]   = $key["niederlagen"];
		$tore[ $team_id ]          = $key["tore"];
		$gegentore[ $team_id ]     = $key["gegentore"];
		$differenz[ $team_id ]     = $key["tore"] - $key["gegentore"];
		$punkte[ $team_id ]        = $key["punkte"];
	endforeach;

	array_multisort( $punkte, SORT_DESC, $differenz, SORT_DESC, $tore, SORT_DESC, $arTeam );

	return $arTeam;
}

?>
