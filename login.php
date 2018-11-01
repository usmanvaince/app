<?php
$pageKey  = 'login';
$pageName = 'login';
session_start();


include("functions/functions.php");

if (isset($_POST["submit_login"])):
	$user_nick = mysqli_real_escape_string($connection, $_POST["user_nick"]);
	$user_pw = mysqli_real_escape_string($connection, $_POST["user_pw"]);

	$query = mysqli_query($connection, "SELECT user_id, user_nick, user_vorname, user_nachname, user_pw, user_status FROM fifa_user WHERE user_nick LIKE '$user_nick' LIMIT 1");
	$db = $query->fetch_object();

	if ($db->user_status == "ban"):
		header("Location: error/gebannt.php");
    elseif ($db->user_pw == md5($user_pw)):
		$_SESSION["expire"] = time() + 5400;
		$_SESSION["user_id"] = $db->user_id;
		$_SESSION["user_name"] = $db->user_nick;
		$_SESSION["user_fullname"] = $db->user_vorname . " " . $db->user_nachname;
		$_SESSION["user_status"] = $db->user_status;
		$_SESSION["ip"] = $_SERVER["REMOTE_ADDR"];
		$_SESSION["browser"] = $_SERVER["HTTP_USER_AGENT"];

		mysqli_query($connection, "INSERT INTO fifa_session (session_id, session_expire, session_userid, session_ip, session_browser) VALUES ('" . session_id() . "', '" . $_SESSION["expire"] . "', '" . $_SESSION["user_id"] . "', '" . $_SESSION["ip"] . "', '" . $_SESSION["browser"] . "')");

		if( $_SESSION["user_status"] === 'admin') {
			header("Location: /admin/dashboard.php");
		} else {
			header("Location: /user/dashboard.php");
		}
	else:
        // falsche Zugangsdaten
		$location = 'login.php?param=info';
		header('Location: ' . $location);

	endif;
else:
	require_once "templates/header.php";
	?>
	<?php if(isset($_GET['param']) && $_GET['param'] == 'info') { ?>
        <div class="alert alert-danger alert-with-icon">
            <i class="material-icons" data-notify="icon" >error_outline</i>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">x</button>
            <span data-notify="message"> <b>Fehler:</b> Ihre Zugangsdaten sind leider nicht korrekt! </span>
        </div>
    <?php } ?>

	<?php if(isset($_GET['param']) && $_GET['param'] == 'turnieranmeldung') { ?>
    <div class="alert alert-danger alert-with-icon">
        <i class="material-icons" data-notify="icon" >error_outline</i>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">x</button>
        <span data-notify="message"> <b>Info</b> Um dich für das Turnier anzumelden brauchst du einen Benutzeraccount. Wenn du bereits einen Benutzeraccount hast, dann melde Dich bitte an. Ansonsten musst du dich registrieren.<br>
        In deinem Dashboard findest du die Anmeldung zum Turnier.</span>
    </div>
<?php } ?>

    <?php if(isset($_GET['param']) && $_GET['param'] == 'registered') { ?>
    <div class="alert alert-success alert-with-icon">
        <i class="material-icons" data-notify="icon">check</i>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">x</button>
        <span data-notify="message"> <b>Erfolg:</b> Du hast dich erfolgreich registriert. Du kannst Dich nun einloggen. </span>
    </div>
<?php } ?>

    <div class="wrapper wrapper-full-page">
        <div class="full-page login-page" filter-color="black" data-image="../../assets/img/login.jpeg">
            <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3" id="login_panel">
                            <form method="POST" action="">
                                <div class="card card-login">
                                    <div class="card-header text-center" data-background-color="orange">
                                        <h4 class="card-title">Login</h4>
                                    </div>
                                    <p class="category text-center">

                                    </p>
                                    <div class="card-content">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">face</i>
                                            </span>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label">Username:</label>
                                                <input type="text" name="user_nick" class="form-control" required>
                                                <span class="material-input"></span></div>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label">Password</label>
                                                <input name="user_pw" type="password" class="form-control" required>
                                                <span class="material-input"></span></div>
                                        </div>
                                    </div>
                                    <div class="footer text-center">
                                        <button type="submit" name="submit_login"
                                                class="btn btn-primary btn-round">Anmelden
                                        </button>
                                    </div>
                                    <div class="forgot_password text-center">
                                        <a href="#" id="open_login_forgot_password">Passwort vergessen?</a>
                                        <a href="register.php">Keinen Zugang?</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3" id="forgot_password_panel"
                             style="display: none;">
                            <form method="POST" action="lostpw.php">
                                <div class="card card-login">
                                    <div class="card-header text-center" data-background-color="orange">
                                        <h4 class="card-title">Passwort zurücksetzen</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label">E-Mail Adresse</label>
                                            <input type="email" name="user_email" class="form-control" required>
                                            <span class="material-input"></span>
                                        </div>

                                    </div>
                                    <div class="footer text-center">
                                        <button type="submit" name="submit_lostpw"
                                                class="btn btn-primary btn-round">Passwort zurücksetzen
                                        </button>
                                    </div>
                                    <div class="forgot_password text-center">
                                        <a href="#" id="open_login">Zurück zum Login</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="full-page-background" style="background-image: url(../templates/assets/img/login.jpeg) "></div></div>
    </div>
	<?php
	require_once "templates/footer.php";
endif;
?>


