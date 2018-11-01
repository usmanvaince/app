<?php
$pageKey           = 'register';
$pageName          = 'registrieren';

include( "functions/functions.php" );

if ( isset( $_POST["submit_registrierung"] ) ) {
    $userNick = mysqli_real_escape_string($connection, $_POST["user_nick"]);
    $userFirstName = mysqli_real_escape_string($connection, $_POST["user_vorname"]);
    $userLastName = mysqli_real_escape_string($connection, $_POST["user_nachname"]);
    $userPhone = mysqli_real_escape_string($connection, $_POST["user_phone"]);
    $userPlz = mysqli_real_escape_string($connection, $_POST["user_plz"]);
    $userCountry = mysqli_real_escape_string($connection, $_POST["user_country"]);
    $userEmail = mysqli_real_escape_string($connection, $_POST["user_email"]);
    $userPw = mysqli_real_escape_string($connection, $_POST["user_pw"]);
    $userPwRepeat = mysqli_real_escape_string($connection, $_POST["user_pw_repeat"]);
    $userAcceptData = mysqli_real_escape_string($connection, $_POST['user_accept_data']);

    $errorMessage = '';
    $checkEmptyFields = false;
    $check1 = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM fifa_user WHERE user_nick = '$userNick'"));
    $check2 = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM fifa_user WHERE user_email = '$userEmail'"));
    $json = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6LcBbkUUAAAAABtLi_RlSZIlc-AzDJkoqCojBU0B&response=' . $_POST['g-recaptcha-response']);
    $data = json_decode($json);
    $registerSuccess = false;

    if (empty($userNick) || empty($userFirstName) || empty($userLastName) || empty($userPhone) || empty($userEmail) || empty($userPw) || empty($userPwRepeat) || empty($userPlz) || empty($userCountry)) {
        $checkEmptyFields = false;
    } else {
        $checkEmptyFields = true;
    }

    if ($check1 > 0) {
        $errorMessage = 'Der Benutzername ist bereits vergeben.';
    } elseif ($check2 > 0) {
        $errorMessage = 'Die E-Mail Adresse ist bereits registriert.';
    } elseif ($checkEmptyFields == false) {
        $errorMessage = 'Bitte fülle alle Felder aus.';
    } elseif ($userPw != $userPwRepeat) {
        $errorMessage = 'Deine Passwörter stimmen nicht überein.';
    } elseif (strlen($userPw) < 8) {
        $errorMessage = 'Dein Passwort muss mindestens 8 Zeichen lang sein.';
    } elseif (!$userAcceptData) {
        $errorMessage = 'Du musst die Datenschutzbedingungen akzeptieren.';
    } elseif ($data->success == false) {
        $errorMessage .= 'Du musst das Captcha akzeptieren.';
    } else {
        mysqli_query($connection, "INSERT INTO fifa_user (user_nick, user_vorname, user_nachname, user_zip_code, user_country , user_phone, user_pw, user_email, user_status, signin) VALUES ('$userNick', '$userFirstName', '$userLastName', '$userPlz', '$userCountry', '$userPhone', '" . md5($userPw) . "', '$userEmail', 'user', '$time')");
        $registerSuccess = true;

        /* mail versenden */
	    $query = mysqli_query($connection,"SELECT user_nick, user_email FROM fifa_user WHERE user_email = '$userEmail'");
	    $db = $query->fetch_object();

	    $mail_empfaenger = $userEmail;
	    $mail_titel = "Deine Registrierung bei esport event gmbh";
	    $mail_text = '
			    <h1 style="Margin: 0; Margin-bottom: 10px; color: inherit; font-family: Arial, sans-serif; font-size: 34px; font-weight: normal; line-height: 1.3; margin: 0; margin-bottom: 10px; padding: 0; text-align: left; word-wrap: normal;">
			    Hallo ' . $db->user_nick . ',
			    </h1>
                <p style="Margin: 0; Margin-bottom: 10px; color: #0a0a0a; font-family: Arial, sans-serif; font-size: 16px; font-weight: normal; line-height: 1.3; margin: 0; margin-bottom: 10px; padding: 0; text-align: left;">
                    du hast dich erfolgreich auf unserer eSport Events Plattform angemeldet.<br> Hier findest du immer wieder Offline- sowie Online-Turniere.<br>
                    <br> Vervollständige noch deine Daten in deinem persönlichen Profil und melde dich hier auf unserer Plattform an: <a href="http://app.esport-event.de/login.php" style="Margin: 0; color: #333333; font-family: Arial, sans-serif; font-weight: bold; line-height: 1.3; margin: 0; padding: 0; text-align: left; text-decoration: underline;">zum Login</a><br>

                    <br>
                    <br> Viel Spass<br>
                    <br> Dein eSport Events Team
                </p>
			';


	    include("mail/mailvorlage.php");

	    $mail_head = "Content-type: text/html;charset=utf-8\n";
	    $mail_head .= "From: info@esport-event.gmbh\r\n";
	    $mail_head .= "X-Mailer: PHP/".phpversion();

	    mail($mail_empfaenger, $mail_titel, $mail_body, $mail_head);

	    header("Location: login.php?param=registered");
    }
}


require_once "templates/header.php";
?>
<?php if ( !empty($errorMessage) ) { ?>
    <div class="alert alert-danger alert-with-icon">
        <i class="material-icons" data-notify="icon">error_outline</i>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">x</button>
        <span data-notify="message"> <b>Fehler:</b> <?php echo $errorMessage; ?> </span>
    </div>
<?php } ?>

<?php if (!$registerSuccess) { ?>
    <div class="wrapper wrapper-full-page">
        <div class="full-page login-page" filter-color="black" data-image="../../assets/img/login.jpeg">
            <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <form method="POST" action="">
                                <div class="card card-signup">
                                    <h2 class="card-title text-center">Registrierung</h2>
                                    <div class="row">
                                        <div class="col-md-6 col-md-offset-3">
                                            <div class="card-content">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person_outline</i>
                                                    </span>
                                                    <div class="form-group is-empty">
                                                        <input name="user_nick" type="text" class="form-control"
                                                               value="<?php echo $userNick; ?>"
                                                               placeholder="Username...">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">face</i>
                                                    </span>
                                                    <div class="form-group is-empty">
                                                        <input name="user_vorname" type="text" class="form-control"
                                                               value="<?php echo $userFirstName; ?>"
                                                               placeholder="Vorname...">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">face</i>
                                                    </span>
                                                    <div class="form-group is-empty">
                                                        <input name="user_nachname" type="text" class="form-control"
                                                               value="<?php echo $userLastName; ?>"
                                                               placeholder="Nachname...">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">my_location</i>
                                                    </span>
                                                    <div class="form-group is-empty">
                                                        <input name="user_plz" type="text" class="form-control"
                                                               value="<?php echo $userPlz; ?>"
                                                               placeholder="Postleitzahl...">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">place</i>
                                                    </span>
                                                    <div class="form-group is-empty">
                                                        <input name="user_country" type="text" class="form-control"
                                                               value="<?php echo $userCountry; ?>"
                                                               placeholder="Land...">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">phone</i>
                                                    </span>
                                                    <div class="form-group is-empty">
                                                        <input name="user_phone" type="text" class="form-control"
                                                               value="<?php echo $userPhone; ?>"
                                                               placeholder="Whatsapp-Nummer...">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">email</i>
                                                    </span>
                                                    <div class="form-group is-empty">
                                                        <input name="user_email" type="text" class="form-control"
                                                               value="<?php echo $userEmail; ?>" placeholder="Email...">
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">lock_outline</i>
                                                    </span>
                                                    <div class="form-group is-empty">
                                                        <input name="user_pw" type="password" placeholder="Passwort..."
                                                               value="<?php echo $userPw; ?>" class="form-control">
                                                        <span class="material-input"></span></div>
                                                </div>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">lock_outline</i>
                                                    </span>
                                                    <div class="form-group is-empty">
                                                        <input name="user_pw_repeat" type="password"
                                                               placeholder="Passwort wiederholen..."
                                                               value="<?php echo $userPwRepeat; ?>"
                                                               class="form-control">
                                                        <span class="material-input"></span></div>
                                                </div>
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="user_accept_data" type="checkbox">
                                                        Ich stimme den <a href="<?php echo $domain; ?>/datenschutz.php">Datenschutzbedingungen</a>
                                                        zu.
                                                    </label>
                                                </div>
                                                <div class="g-recaptcha"
                                                     data-sitekey="6LcBbkUUAAAAAPd3iuR6fCiqC_6CnA6RQ_HxHDdn"></div>
                                                <div class="footer text-center">
                                                    <button type="submit" name="submit_registrierung"
                                                            class="btn btn-primary btn-round">
                                                        Registrieren
                                                    </button>
                                                </div>
                                                <div class="text-center">
                                                    Bereits registriert? <a href="<?php echo $domain; ?>/login.php"
                                                                            id="open_login">Zum Login</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="full-page-background" style="background-image: url(../templates/assets/img/login.jpeg) "></div>
        </div>
    </div>
    <?php
    require_once "templates/footer.php";
} ?>


