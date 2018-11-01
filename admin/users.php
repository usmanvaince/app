<?php
session_start();

if ( ! isset( $_SESSION["user_id"] ) ):
	header( "Location: ../index.php?info=8" );
elseif ( $_SESSION["user_status"] != "admin" ):
	header( "Location: ../index.php?info=9" );
else:

$pageKey = 'user_users';
$pageName = 'User';

include("../functions/functions.php");
require_once "../templates/header.php";


?>
<div class="wrapper" style="padding-top:70px;">
    <div class="sidebar" style="margin-top:70px;" data-active-color="orange" data-background-color="black" data-image="../templates/assets/img/sidebar-1.jpg">
        <?php require_once "parts/sidebar-admin.php"; ?>
    </div>
    <div class="main-panel">
        <?php require_once "parts/header-menu-admin-dashboard.php"; ?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Mitgliederübersicht
                                </h4>
                            </div>
                            <div class="card-content">
                                <ul class="nav nav-pills nav-pills-warning">
                                    <li class="active">
                                        <a href="#pill1" data-toggle="tab" aria-expanded="true">Mitglieder</a>
                                    </li>
                                    <li class="">
                                        <a href="#pill2" data-toggle="tab" aria-expanded="false">Neueste Mitglieder</a>
                                    </li>
                                    <li class="">
                                        <a href="#pill3" data-toggle="tab" aria-expanded="false">Aktive Mitglieder</a>
                                    </li>
                                    <li class="">
                                        <a href="#pill4" data-toggle="tab" aria-expanded="false">Inaktive Mitglieder</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="pill1">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="text-primary">
                                                <tr>
													<th>ID</th>
                                                    <th>Benutzername</th>
                                                    <th>WhatsApp</th>
													<th>PSN ID</th>
													<th>Xbox Live ID</th>
													<th>Email</th>
                                                    <th>Geburtstag</th>
                                                    <th>Letzte Aktion</th>
                                                </tr></thead>
                                                <tbody>
                                                    <?php
                                                    $query = mysqli_query($connection,"SELECT user_id, user_nick, user_phone, psn_id, xbox_id, user_birthday, user_email, signin, logtime FROM fifa_user ORDER BY user_nick ASC");
                                                    while($db = $query->fetch_object()) {
                                                    ?>
                                                        <tr>
															<td><?php echo $db->user_id; ?></td>
                                                            <td><?php echo $db->user_nick; ?></td>
                                                            <td><?php echo $db->user_phone ?></td>
															<td><?php echo $db->psn_id ?></td>
															<td><?php echo $db->xbox_id ?></td>
															<td><?php echo $db->user_email ?></td>
                                                            <td><?php echo date("d.m.Y", $db->user_birthday); ?></td>
                                                            <td><?php echo date("d.m.Y - H:i", $db->logtime); ?> Uhr</td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="pill2">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="text-primary">
                                                <tr>
                                                    <th>Benutzername</th>
                                                    <th>WhatsApp</th>
													<th>PSN ID</th>
													<th>Xbox Live ID</th>
													<th>Email</th>
                                                    <th>Registriert seit</th>
                                                    <th>Letzte Aktion</th>
                                                </tr></thead>
                                                <tbody>
                                                <?php
                                                $query = mysqli_query($connection,"SELECT user_id, user_nick, user_phone, psn_id, xbox_id, user_birthday, user_email, signin, logtime FROM fifa_user ORDER BY user_id DESC");
                                                while($db = $query->fetch_object()) {
                                                    ?>
                                                    <tr>
                                                            <td class="text-primary"><?php echo $db->user_nick; ?></td>
                                                            <td><?php echo $db->user_phone ?></td>
															<td><?php echo $db->psn_id ?></td>
															<td><?php echo $db->xbox_id ?></td>
															<td><?php echo $db->user_email ?></td>
                                                            <td><?php echo date("d.m.Y", $db->user_birthday); ?></td>
                                                            <td><?php echo date("d.m.Y - H:i", $db->logtime); ?> Uhr</td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="pill3">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="text-primary">
                                                <tr>
                                                    <th>Benutzername</th>
                                                    <th>WhatsApp</th>
													<th>PSN ID</th>
													<th>Xbox Live ID</th>
													<th>Email</th>
                                                    <th>Registriert seit</th>
                                                    <th>Letzte Aktion</th>
                                                </tr></thead>
                                                <tbody>
                                                <?php
                                                $query = mysqli_query($connection,"SELECT user_id, user_nick, user_birthday, user_phone, psn_id, xbox_id, user_email, signin, logtime FROM fifa_user WHERE ADDDATE(FROM_UNIXTIME(logtime), Interval 30 day) > NOW() ORDER BY logtime DESC");
                                                while($db = $query->fetch_object()) {
                                                    ?>
                                                    <tr>
                                                            <td class="text-primary"><?php echo $db->user_nick; ?></td>
                                                            <td><?php echo $db->user_phone ?></td>
															<td><?php echo $db->psn_id ?></td>
															<td><?php echo $db->xbox_id ?></td>
															<td><?php echo $db->user_email ?></td>
                                                            <td><?php echo date("d.m.Y", $db->userbirthday); ?></td>
                                                            <td><?php echo date("d.m.Y - H:i", $db->logtime); ?> Uhr</td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="pill4">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="text-primary">
                                                <tr>
                                                    <th>Benutzername</th>
                                                    <th>WhatsApp</th>
													<th>PSN ID</th>
													<th>Xbox Live ID</th>
													<th>Email</th>
                                                    <th>Registriert seit</th>
                                                    <th>Letzte Aktion</th>
                                                </tr></thead>
                                                <tbody>
                                                <?php
                                                $query = mysqli_query($connection,"SELECT user_id, user_nick, user_birthday, user_phone, psn_id, xbox_id, user_email, signin, logtime FROM fifa_user WHERE ADDDATE(FROM_UNIXTIME(logtime), Interval 30 day) < NOW() ORDER BY logtime DESC");
                                                while($db = $query->fetch_object()) {
                                                    ?>
                                                    <tr>
                                                            <td class="text-primary"><?php echo $db->user_nick; ?></td>
                                                            <td><?php echo $db->user_phone ?></td>
															<td><?php echo $db->psn_id ?></td>
															<td><?php echo $db->xbox_id ?></td>
															<td><?php echo $db->user_email ?></td>
                                                            <td><?php echo date("d.m.Y", $db->birthday); ?></td>
                                                            <td><?php echo date("d.m.Y - H:i", $db->logtime); ?> Uhr</td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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