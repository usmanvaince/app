<?php
session_start();
/*
---------------------------------------------------------
| © 2018 eSport Event GmbH			                                       |
| E-Mail: info@esport-event.gmbh					               |
---------------------------------------------------------
*/

include("../../functions/functions.php");

$turniere_id 	= mysqli_real_escape_string($connection,$_GET["turnier"]);
$action 		= mysqli_real_escape_string($connection,$_GET["action"]);

if($action == "tabelle"):
	require_once "../../templates/header.php";

?>
<div class="container">
    <section class="content-wrapper">
        <div class="row">
            <div class="col-md-12">

<?php
	
	if(getTurniermodusIDVonTurniereID($turniere_id) == 1):
		for($i = 1; $i <= countGruppenVonTurniereID($turniere_id); $i++):
?>
			<div class="col-md-3">
				<div class="box table-responsive">
                	<h2><a href="../turniertabelle/index.php?turnier=<?=$turniere_id?>&gruppe=<?=$i?>">Gruppe <?=$i?></a></h2>
					<table class="table table-bordered">
						<tr bgcolor="#E8E8E8">
							<td width="5%" align="center"><b>Pos.</b></td>
							<td width="85%" align="left"><b>Team</b></td>
							<td width="5%" align="center"><b>Sp.</b></td>
							<td width="5%" align="center"><b>Pkt.</b></td>
						</tr>
<?php
						$k = 1;
						foreach(getTurniergruppentabelleVonWettbewerbeID($turniere_id,$i) AS $array_wert => $key):
?>
							<tr bgcolor="<?=getBgColorVonPlatzierung($k)?>">
								<td align="center"><?=$k?>.</td>
								<td align="left"><?=getTurnierteamVonTurnierteamID($turniere_id,$key["teamid"])?></td>
								<td align="center"><?=0+$key["spiele"]?></td>
								<td align="center"><b><?=0+$key["punkte"]?></b></td>
							</tr>
<?php					
						$k++;
						endforeach;
?>
					</table>
				</div>
			</div>
<?php
		endfor;
	elseif(getTurniermodusIDVonTurniereID($turniere_id) == 2):
		### vorherige Gruppenphase ###
		for($i = 1; $i <= countGruppenVonTurniereID(getTurniergruppenphaseIDVonTurniereID($turniere_id)); $i++):
?>
			<div class="col-md-3">
				<div class="box table-responsive">
                	<h2><a href="../turniertabelle/index.php?turnier=<?=getTurniergruppenphaseIDVonTurniereID($turniere_id)?>&gruppe=<?=$i?>">Gruppe <?=$i?></a></h2>
					<table class="table table-bordered">
						<tr bgcolor="#E8E8E8">
							<td width="5%" align="center"><b>Pos.</b></td>
							<td width="85%" align="left"><b>Team</b></td>
							<td width="5%" align="center"><b>Sp.</b></td>
							<td width="5%" align="center"><b>Pkt.</b></td>
						</tr>
<?php
						$k = 1;
						foreach(getTurniergruppentabelleVonWettbewerbeID(getTurniergruppenphaseIDVonTurniereID($turniere_id),$i) AS $array_wert => $key):
?>
							<tr bgcolor="<?=getBgColorVonPlatzierung($k)?>">
								<td align="center"><?=$k?>.</td>
								<td align="left"><?=getTurnierteamVonTurnierteamID(getTurniergruppenphaseIDVonTurniereID($turniere_id),$key["teamid"])?></td>
								<td align="center"><?=0+$key["spiele"]?></td>
								<td align="center"><b><?=0+$key["punkte"]?></b></td>
							</tr>
<?php					
						$k++;
						endforeach;
?>
					</table>
				</div>
			</div>
<?php
		endfor;

		### aktuelle KO-Runde ###
		for($i = 1; $i <= getTurnierrundenVonTurniereID($turniere_id); $i++):
?>
			<div class="col-md-12">
				<div class="box table-responsive">
					<h2><?=getTurnierrundenname(getTurnierrundenteilnehmerVonTurniereID($turniere_id,$i))?></h2>
					<table class="table table-bordered">
						<tr bgcolor="#E8E8E8">
                        	<td width="5%" align="center"><b>ID</b></td>
                        	<td width="10%" align="center"><b>Spielort</b></td>
                        	<td width="10%" align="center"><b>Datum</b></td>
                        	<td width="35%" align="right"><b>Heim</b></td>
							<td width="5%" align="center"><b>Ergebnis</b></td>
							<td width="35%" align="left"><b>Gast</b></td>
						</tr>
<?php
						$query = mysqli_query($connection,"SELECT turnierspiele_id, team_heim, team_gast, tore_heim, tore_gast, spielinfo, spielort, datum FROM b_spiele WHERE turniere_id = '$turniere_id' AND spieltag = '$i'");
						while($db = $query->fetch_object()):
							if($db->spielinfo == 1):
								$spielinfo = "";
							elseif($db->spielinfo == 2):
								$spielinfo = "<br><small>(n.V.)</small>";
							elseif($db->spielinfo == 3):
								$spielinfo = "<br><small>(n.E.)</small>";
							endif;
							
							if($color == ""):
								$color = " bgcolor='#E8E8E8'";
							else:
								$color = "";
							endif;
?>
						<tr<?=$color?>>
                        	<td align="center"><?=$db->turnierspiele_id?></td>
							<td align="center"><?=$db->spielort?></td>
							<td align="center">
<?php
								if(isset($db->datum)):
									echo date("H:i", $db->datum)." Uhr";
								endif;
?>
							</td>
                            <td align="right"><?=getTurnierteamVonTurnierteamID($turniere_id,$db->team_heim)?></td>
							<td align="center">
                            	<b><?=$db->tore_heim?> : <?=$db->tore_gast?></b>
                                <?=$spielinfo?>
                            </td>
							<td align="left"><?=getTurnierteamVonTurnierteamID($turniere_id,$db->team_gast)?></td>
						</tr>
<?php							
						endwhile;
?>
					</table>
				</div>
			</div>
<?php
		endfor;
	endif;
	
	require_once "../../templates/footer.php";
elseif($action == "teilnehmer"):
	require_once "../../templates/header.php";
?>
	<div class="col-md-12">
		<div class="box table-responsive">
			<h2><?=getTurniernameVonTurniereID($turniere_id)?> - Teilnehmer</h2>
			<table class="table table-bordered">
                <tr bgcolor="#E8E8E8">
                    <td width="5%" align="center"><b>ID</b></td>
                    <td width="65%" align="left"><b>Team</b></td>
                </tr>
<?php
                $query = mysqli_query($connection,"SELECT team_id, team, status FROM b_turnierteams WHERE turniere_id = '$turniere_id'");
                while($db = $query->fetch_object()):
?>
                <tr>
                	<td align="center"><?=$db->team_id?></td>
                    <td align="left"><?=$db->team?></td>
                </tr>
<?php					
                endwhile;
?>	
            </table>
		</div>
	</div>
    </div>
    </div>
    </section>
    </div>
<?php
	require_once "../../templates/footer.php";
endif;
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Fenstertitel</title>
<style type="text/css">
body {
	height: 1500px;
}
</style>
</head>
<body>
<script type="text/javascript">
(function(){
	var step = 4;
	function scroll(){
		var position = window.pageYOffset;
		window.scrollBy(0, step);
		if (position === window.pageYOffset){
			step *= -1;
			window.setTimeout(scroll, 9000);
		}
		else {
			window.setTimeout(scroll, 10);
		}
	}
	window.setTimeout(scroll, 9000);
}());
</script>
</body>
</html>