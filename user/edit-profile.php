<?php

session_start();

if (!isset($_SESSION["user_id"])):
    header("Location: ../../index.php?info=8");
elseif ($_SESSION["user_status"] == "admin"):
    header("Location: ../../index.php?info=9");
else:

$pageKey = 'edit_profile';
$pageName = 'Profil bearbeiten';

include("../functions/functions.php");
require_once "../templates/header.php";

$query_profile = mysqli_query($connection,"SELECT * FROM fifa_user WHERE user_id = '".$_SESSION["user_id"]."'");
$db_profile = $query_profile->fetch_object();

?>
<div class="wrapper" style="padding-top:70px;">
    <div class="sidebar" style="margin-top:70px;" data-active-color="orange" data-background-color="black" data-image="../templates/assets/img/sidebar-1.jpg">
        <?php require_once "parts/sidebar-user.php"; ?>
    </div>
    <div class="main-panel">
        <?php require_once "parts/header-menu-user-dashboard.php"; ?>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="orange">
                                <i class="material-icons">perm_identity</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Profil bearbeiten -
                                    <small class="category">Bitte vervollständige Dein Profil</small>
                                </h4>
                                <?php
                                /*var_dump($_POST['user_mail']);
                                var_dump($_POST['user_firstname']);
                                var_dump($_POST['user_name']);
                                var_dump($_POST['user_phone']);
                                var_dump($_POST['user_psn']);
                                //var_dump($_POST['user_nick']);
                                var_dump($_POST['user_xbox']);
                                var_dump($_POST['user_fb']);
                                var_dump($_POST['user_twitch']);
                                var_dump($_SESSION['user_id']);*/
                                if (isset($_POST["submit_user"])) {
                                    //mysqli_query($connection,"UPDATE fifa_user SET user_email = '".$_POST['user_mail']."',user_vorname = '".$_POST['user_firstname']."', user_nachname = '".$_POST['user_name']."', user_phone = '".$_POST['user_phone']."', psn_id = '".$_POST['user_psn']."', user_nick = '".$_POST['user_nick']."', xbox_id = '".$_POST['user_xbox']."', facebook = '".$_POST['user_fb']."', twitch = '".$_POST['user_twitch']."' WHERE user_id = '".$_SESSION['user_id']."'");
                                    mysqli_query($connection,"UPDATE fifa_user SET user_email = '".$_POST['user_mail']."',  user_vorname = '".$_POST['user_firstname']."', user_nachname = '".$_POST['user_name']."', user_birthday = '".$_POST['user_birthday']."', user_adress = '".$_POST['user_adress']."', user_adress_number = '".$_POST['user_adress_number']."', user_zip_code = '".$_POST['user_zip_code']."', user_city = '".$_POST['user_city']."', user_country = '".$_POST['user_country']."', user_phone = '".$_POST['user_phone']."', psn_id = '".$_POST['user_psn']."', xbox_id = '".$_POST['user_xbox']."', facebook = '".$_POST['user_fb']."', twitch = '".$_POST['user_twitch']."' WHERE user_id = '".$_SESSION['user_id']."'");

                                    header("Location: edit-profile.php ");
                                }
                                $query_profile = mysqli_query($connection,"SELECT * FROM fifa_user WHERE user_id = '".$_SESSION["user_id"]."'");
                                $db_profile = $query_profile->fetch_object();
                                ?>
                                <form method="POST" action="">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label">Username (deaktiviert)</label>
                                                <input name="user_nick" type="text" class="form-control" disabled="" value="<?=$db_profile->user_nick ?>">
                                                <span class="material-input"></span></div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label">E-Mail Adresse</label>
                                                <input name="user_mail" type="email" class="form-control" value="<?=$db_profile->user_email ?>">
                                                <span class="material-input"></span></div>
                                        </div>
										<div class="col-md-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label">Geburtsdatum</label>
                                                <input name="user_birthday" type="date" name="bday" class="form-control" value="<?=$db_profile->user_birthday ?>">
                                                <span class="material-input"></span></div>
                                        </div>
                                        <div class="col-md-4">
                                            <!--<div class="form-group label-floating">
                                                <label class="control-label">Geburtsdatum</label>
                                                <input name="user_birthday" type="text" class="form-control datepicker" value="<?/*=date("d.m.Y",$db_profile->user_birthday)*/?>">
                                                <span class="material-input"></span></div>-->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label">Vorname</label>
                                                <input name="user_firstname" type="text" class="form-control" value="<?=$db_profile->user_vorname ?>">
                                                <span class="material-input"></span></div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label">Nachname</label>
                                                <input name="user_name" type="text" class="form-control" value="<?=$db_profile->user_nachname ?>">
                                                <span class="material-input"></span></div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label">Whatsapp Handynummer</label>
                                                <input name="user_phone" type="text" class="form-control" value="<?=$db_profile->user_phone ?>">
                                                <span class="material-input"></span></div>
                                        </div>
                                    </div>
										<div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label">Adresse</label>
                                                <input name="user_adress" type="text" class="form-control" value="<?=$db_profile->user_adress ?>">
                                                <span class="material-input"></span></div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label">Hausnummer</label>
                                                <input name="user_adress_number" type="text" class="form-control" value="<?=$db_profile->user_adress_number ?>">
                                                <span class="material-input"></span></div>
                                        </div>
									</div>
										<div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label">PLZ</label>
                                                <input name="user_zip_code" type="text" class="form-control" value="<?=$db_profile->user_zip_code ?>">
                                                <span class="material-input"></span></div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label">Stadt</label>
                                                <input name="user_city" type="text" class="form-control" value="<?=$db_profile->user_city ?>">
                                                <span class="material-input"></span></div>
                                  	      </div>
										<div class="col-md-4">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label">Land</label>
                                                <input name="user_country" type="text" class="form-control" value="<?=$db_profile->user_country ?>">
                                                <span class="material-input"></span></div>
                                  	      </div>
                                        </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label">PSN ID</label>
                                                <input name="user_psn" type="text" class="form-control" value="<?=$db_profile->psn_id ?>">
                                                <span class="material-input"></span></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label">Xbox Live ID</label>
                                                <input name="user_xbox" type="text" class="form-control" value="<?=$db_profile->xbox_id ?>">
                                                <span class="material-input"></span></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label">Facebook</label>
                                                <input name="user_fb" type="text" class="form-control" value="<?=$db_profile->facebook ?>">
                                                <span class="material-input"></span></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label">Twitch</label>
                                                <input name="user_twitch" type="text" class="form-control" value="<?=$db_profile->twitch ?>">
                                                <input type="hidden" name="user_id_post" value="<?=$db_profile->user_id ?>"
                                                <span class="material-input"></span></div>
                                        </div>
                                    </div>

                                    <button name="submit_user" type="submit" class="btn btn-rose pull-right">Profil aktualisieren</button>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-profile">
                            <div class="card-avatar">
                                <a href="#pablo">
                                    <img class="img" src="../templates/assets/img/avatar_placeholder.png">
                                </a>
                            </div>
                            <div class="card-content">
                                <h6 class="category text-gray"><?=$db_profile->user_nick ?></h6>
                                <h4 class="card-title"><?=$db_profile->user_vorname.' ' ?><?=$db_profile->user_nachname ?></h4>
                                <!--<a href="<?php /*echo $domain; */?>user/edit-profile.php" class="btn btn-primary btn-round">Profil bearbeiten</a>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include_once "../templates/footer_dashboard.php";
        ?>
    </div>
</div>



<?php include_once "../templates/scripts.php"; ?>

</body>
</html>

<?php endif; ?>



