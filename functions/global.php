<?php
/*
---------------------------------------------------------
| © 2018 eSport Event GmbH			                                       |
| E-Mail: info@esport-event.gmbh					               |
---------------------------------------------------------
*/

// Domain
$domain = "https://localhost/app/";

// deutsche Währung
setlocale(LC_MONETARY, 'de_DE');

// Zeitformate
$date = date("Y-m-d");
$datetime = date("Y-m-d H:i:s");
$time = time();
$log_grenze = time() - 1800;

// Globale Funktionen
function la($var) {
    if(is_array($var)):
        echo '<table border=0 style="border:2px solid grey;font:11px Verdana,Tahoma,Arial,Calibri,Geneva,sans-serif;">';

        foreach($var as $key => $value):
            echo '<tr style="border:1px solid #d6d6d6">',
            '<td style="border:1px dashed black;padding:1px;">',
                '<span style="color:#469DFA;font-weight:bold">'.$key.'</span>',
            '</td>',
            '<td>',
            la($value),
            '</td>',
            '</tr>';
        endforeach;
        echo '</table>';
    else:
        $type = gettype($var);
        echo '<div style="padding:10px;border:1px solid #d6d6d6;"><span style="color:red;font-weight:bold;">'.$var.'</span> vom Typ <span style="color:#084B8A">'.$type.'</span></div>';
    endif;
}
function StringRandom($length) {
    $chardef = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz0123456789';
    $string	= '';

    for($i = 0; $i < $length; $i++):
        $string .= substr($chardef,mt_rand(0,71),1);
    endfor;

    return $string;
}
function getBgColorVonPlatzierung($platzierung) {
    /*if($platzierung <= 2):
        $bgcolor = "#FFCA00";
    else:
        $bgcolor = "";
    endif;

    return $bgcolor;*/
}
function countTurniere() {
    global $connection;
    $anzahl = mysqli_num_rows(mysqli_query($connection,"SELECT * FROM b_turniere WHERE turniergruppenphase_id IS Null"));

    return $anzahl;
}
function countTeilnehmer() {
    global $connection;
    $query = mysqli_query($connection,"SELECT spielmodus, turnierteilnehmer FROM b_turniere WHERE turniergruppenphase_id IS Null AND gestartet = '1' AND beendet = '1'");
    while($db = $query->fetch_object()):
        if($db->spielmodus == 1):
            $gesTeilnehmer += $db->turnierteilnehmer;
        elseif($db->spielmodus == 2):
            $gesTeilnehmer += ($db->turnierteilnehmer * 2);
        endif;
    endwhile;

    return $gesTeilnehmer;
}
function countSpiele() {
    global $connection;
    $anzahl = mysqli_num_rows(mysqli_query($connection,"SELECT * FROM b_spiele"));

    return $anzahl;
}
function countTore() {
    global $connection;
    $query = mysqli_query($connection,"SELECT SUM(tore_heim) AS gesHeimtore, SUM(tore_gast) AS gesGasttore FROM b_spiele");
    $db = $query->fetch_object();

    $gesTore = $db->gesHeimtore + $db->gesGasttore;

    return $gesTore;
}
?>