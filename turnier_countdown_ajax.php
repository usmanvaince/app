<?php

include("functions/functions.php");
// turnierAjax.php

if(isset($_GET['id']) && is_numeric($_GET['id'])) {

	$query_turnier = mysqli_query($connection, "SELECT turnierstart FROM b_turniere WHERE turniere_id = '" . $_GET['id'] . "'");
	$fetch = $query_turnier->fetch_object();

    /*$sqlStatement = 'SELECT * FROM blabla WHERE id = ' . mysqli_real_escape($_GET['id']);
    $query = mysqli_query($sqlStatement);*/
    // Einzelnes Object Fetch
    /*$fetch = $query->fetch_object();*/
	$fetch->turnierstart = date('Y/m/d H:i:s', $fetch->turnierstart);
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($fetch, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

}
?>