<?php

session_start();

if (!isset($_SESSION["user_id"])):
    header("Location: ../../index.php?info=8");
elseif ($_SESSION["user_status"] == "admin"):
    header("Location: ../../index.php?info=9");
else:

$pageKey = 'user_profile';
$pageName = 'Profil';

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
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="card card-profile">
                            <div class="card-avatar">
                                <a href="#pablo">
                                    <img class="img" src="../templates/assets/img/avatar_placeholder.png">
                                </a>
                            </div>
                            <div class="card-content">
                                <h6 class="category text-gray"><?=$db_profile->user_nick ?></h6>
                                <h4 class="card-title"><?=$db_profile->user_vorname.' ' ?><?=$db_profile->user_nachname ?></h4>
                                <a href="<?php echo $domain; ?>user/edit-profile.php" class="btn btn-primary btn-round">Profil bearbeiten</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card">
                                <div class="card-header card-header-icon" data-background-color="orange">
                                    <i class="material-icons">account_circle</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Mein Profil</h4>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <td>Username</td>
                                                <td class="text-primary"><?=$db_profile->user_nick ?></td>
                                            </tr>
                                            <tr>
                                                <td>Vorname</td>
                                                <td class="text-primary"><?=$db_profile->user_vorname ?></td>
                                            </tr>
                                            <tr>
                                                <td>Name</td>
                                                <td class="text-primary"><?=$db_profile->user_nachname ?></td>
                                            </tr>
                                            <!--<tr>
                                                <td>Geburtstag</td>
                                                <td class="text-primary"><?/*=date("d.m.Y",$db_profile->user_birthday)*/?></td>
                                            </tr>-->
                                            <tr>
                                                <td>Email</td>
                                                <td class="text-primary"><?=$db_profile->user_email ?></td>
                                            </tr>
                                            <tr>
                                                <td>Whatsapp Handynummer</td>
                                                <td class="text-primary"><?=$db_profile->user_phone ?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="orange">
                                <i class="material-icons">info</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Zusätzliche Daten</h4>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td>PSN ID</td>
                                            <td class="text-primary"><?=$db_profile->psn_id ?></td>
                                        </tr>
                                        <tr>
                                            <td>Xbox Live ID</td>
                                            <td class="text-primary"><?=$db_profile->xbox_id ?></td>
                                        </tr>
                                        <tr>
                                            <td>Facebook</td>
                                            <td class="text-primary"><?=$db_profile->facebook ?></td>
                                        </tr>
                                        <tr>
                                            <td>Twitch</td>
                                            <td class="text-primary"><?=$db_profile->twitch ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
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