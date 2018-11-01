<?php
session_start();
/*
---------------------------------------------------------
| © 2018 eSport Event GmbH			                                       |
| E-Mail: info@esport-event.gmbh					               |
---------------------------------------------------------
*/

include("functions/functions.php");

if(isset($_SESSION["user_id"])):
	mysqli_query($connection,"DELETE FROM fifa_session WHERE session_userid = '".$_SESSION["user_id"]."'");
	session_destroy();
	
	header("Location: index.php");
else:
	header("Location: index.php?info=4");
endif;
?>