<?php
/*
---------------------------------------------------------
| © 2018 eSport Event GmbH			                                       |
| E-Mail: info@esport-event.gmbh					               |
---------------------------------------------------------
*/

include("functions/functions.php");

$mode = mysqli_real_escape_string($connection,$_GET["mode"]);

if($mode == ""):
	if(isset($_POST["submit_lostpw"])):
		$user_email = strtolower(mysqli_real_escape_string($connection,$_POST["user_email"]));
		$check = mysqli_num_rows(mysqli_query($connection,"SELECT * FROM fifa_user WHERE user_email = '$user_email'"));
		
		if($check == 0):
			header("Location: index.php?info=7");
		else:
			$query = mysqli_query($connection,"SELECT user_nick, user_email FROM fifa_user WHERE user_email = '$user_email'");
			$db = $query->fetch_object();
			
			$uid = StringRandom(16);
			$link = $domain."lostpw.php?mode=newpw&uid=".$uid;
			
			mysqli_query($connection,"UPDATE fifa_user SET uid = '$uid' WHERE user_email = '$user_email'");
			
			$mail_empfaenger = $db->user_email;
			$mail_titel = "esport event gmbh - Passwortanforderung";
			$mail_text = '
			    <h1 style="Margin: 0; Margin-bottom: 10px; color: inherit; font-family: Arial, sans-serif; font-size: 34px; font-weight: normal; line-height: 1.3; margin: 0; margin-bottom: 10px; padding: 0; text-align: left; word-wrap: normal;">
			    Hallo ' . $db->user_nick . ',
			    </h1>
                <p style="Margin: 0; Margin-bottom: 10px; color: #0a0a0a; font-family: Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0; margin-bottom: 10px; padding: 0; text-align: left;">
                    <br /><br />
                    
                        solltest Du diese E-Mail nicht angefordert haben bzw. Dein Passwort nicht vergessen haben, lösche bitte diese E-Mail.
                                <br />
                        Wenn Du diese E-Mail angefordert hast, erhältst Du hiermit einen Zugangscode um ein neues Passwort festzulegen. Klicke hierzu einfach auf den unten angegebenen Link.
                        <br />
						 '.$link.'<br>

                    <br>
                    <br> Vielen Dank<br>
                    <br> Dein eSport Events Team
                </p>
			';

			
			include("mail/mailvorlage.php");
			
			$mail_head = "Content-type: text/html;charset=utf-8\n";
			$mail_head .= "From: info@esport-event.gmbh\r\n";
			$mail_head .= "X-Mailer: PHP/".phpversion();
			
			mail($mail_empfaenger, $mail_titel, $mail_body, $mail_head);
			
			require_once "templates/header.php";
?>
            <div class="col-md-12">
                <div class="box table-responsive">
                    <h2>Information</h2>
                    <table class="table table-bordered">
                        <tr>
                            <td width="100%" align="left">
                                An Ihre E-Mail-Adresse wurde eine E-Mail mit einem Zugangscode zur Änderung Ihres Passwortes gesendet.
                                Folgen Sie bitten den Anweisungen die Sie in der E-Mail finden.
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
<?php
			require_once "templates/footer.php";
		endif;
	endif;
elseif($mode == "newpw"):
	if(isset($_POST["submit_newpw"])):
		$user_id 	= mysqli_real_escape_string($connection,$_POST["user_id"]);
		$passwort1 	= mysqli_real_escape_string($connection,$_POST["passwort1"]);
		$passwort2 	= mysqli_real_escape_string($connection,$_POST["passwort2"]);
		
		if($passwort1 != $passwort2):
			header("Location: index.php?info=6");
		elseif(strlen($passwort1) < 8):
			header("Location: index.php?info=1");
		else:
			mysqli_query($connection,"UPDATE fifa_user SET uid = '', user_pw = '".md5($passwort1)."' WHERE user_id = '$user_id'");
			
			require_once "templates/header.php";
?>
            <div class="col-md-12">
                <div class="box table-responsive">
                    <h2>Information</h2>
                    <table class="table table-bordered">
                        <tr>
                            <td width="100%" align="left"><b>Ihr Passwort wurde erfolgreich geändert. Sie können sich nun damit einloggen.</b></td>
                        </tr>
                    </table>
                </div>
            </div>
<?php
			require_once "templates/footer.php";
		endif;
	else:
		$uid = mysqli_real_escape_string($connection,$_GET["uid"]);
	
		$query = mysqli_query($connection,"SELECT user_id, user_nick FROM fifa_user WHERE uid = '$uid'");
		$db = $query->fetch_object();
		
		require_once "templates/header.php";
?>
        <div class="col-md-12">
            <div class="box table-responsive">
                <h2>Neues Passwort festlegen für <?=$db->user_nick?></h2>
                <form method="POST" action="">
                    <table class="table table-bordered">
                        <tr>
                            <td width="25%" align="left"><b>Neues Passwort</b></td>
                            <td width="75%" align="left"><input type="password" name="passwort1" class="form-control" required /></td>
                        </tr>
                        <tr>
                            <td align="left"><b>Neues Passwort wiederholen</b></td>
                            <td align="left"><input type="password" name="passwort2" class="form-control" required /></td>
                        </tr>
                        <tr>
                            <td width="100%" align="center" colspan="3">
                                <input type="hidden" name="user_id" value="<?=$db->user_id?>" />
                                <button type="submit" name="submit_newpw" class="btn btn-primary form-control">Passwort ändern</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
<?php
		require_once "templates/footer.php";
	endif;
endif;
?>