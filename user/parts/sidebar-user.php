<?php
session_start();

if (!isset($_SESSION["user_id"])):
    header("Location: ../../index.php?info=8");
elseif ($_SESSION["user_status"] == "admin"):
    header("Location: ../../index.php?info=9");
else:

$query_profile = mysqli_query($connection,"SELECT * FROM fifa_user WHERE user_id = '".$_SESSION["user_id"]."'");
$db_profile = $query_profile->fetch_object();


?>

<div class="logo">
            <a href="<?php echo $domain; ?>" class="simple-text logo-mini">
                -
            </a>
            <a href="<?php echo $domain; ?>" class="simple-text logo-normal">
                eSport Events
            </a>
        </div>
        <div class="sidebar-wrapper">
            <div class="user">
                <div class="photo">
                    <img src="../templates/assets/img/avatar_placeholder.png" />
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                            <span>
                                <?=$db_profile->user_nick?>
                                <b class="caret"></b>
                            </span>
                    </a>
                    <div class="clearfix"></div>
                    <div class="collapse" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="<?php echo $domain; ?>user/profile.php">
                                    <span class="sidebar-mini"> MP </span>
                                    <span class="sidebar-normal"> Mein Profil </span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $domain; ?>user/edit-profile.php">
                                    <span class="sidebar-mini"> PB </span>
                                    <span class="sidebar-normal"> Profil bearbeiten </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav">
                <li class="<?php if ($pageKey == 'user_dashboard') { echo 'active'; } ?>">
                    <a href="<?php echo $domain; ?>user/dashboard.php">
                        <i class="material-icons">dashboard</i>
                        <p> Dashboard </p>
                    </a>
                </li>
               <!-- <li class="<?php /*if ($pageKey == 'user_events') { echo 'active'; } */?>">
                    <a href="<?php /*echo $domain; */?>user/events.php">
                        <i class="material-icons">date_range</i>
                        <p> Nächste Events </p>
                    </a>
                </li>-->
                <li class="<?php if ($pageKey == 'user_statistics') { echo 'active'; } ?>">
                    <a href="<?php echo $domain; ?>user/statistics.php">
                        <i class="material-icons">equalizer</i>
                        <p> Statistiken </p>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $domain; ?>logout.php">
                        <i class="material-icons">cancel</i>
                        <p> Logout </p>
                    </a>
                </li>

            </ul>
        </div>

<?php endif; ?>