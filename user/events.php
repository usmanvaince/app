<?php

session_start();

if (!isset($_SESSION["user_id"])):
    header("Location: ../../index.php?info=8");
elseif ($_SESSION["user_status"] == "admin"):
    header("Location: ../../index.php?info=9");
else:

$pageKey = 'user_events';
$pageName = 'Events';

include("../functions/functions.php");
require_once "../templates/header.php";

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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="orange">
                                <i class="material-icons">date_range</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Nächste Events</h4>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="text-primary">
                                        <tr>
                                            <th>Turnierserie</th>
                                            <th>Name</th>
                                            <th>Ort</th>
                                            <th>Turnierart</th>
                                            <th>Turniermodus</th>
                                            <th>Datum</th>
                                            <th></th>
                                        </tr></thead>
                                        <tbody>
                                        <tr>
                                            <td>eSports-Cup</td>
                                            <td>eParadise</td>
                                            <td>Zürich</td>
                                            <td>offline</td>
                                            <td>2 vs. 2</td>
                                            <td>03.02.2018</td>
                                            <td><button class="btn btn-primary btn-round">Jetzt anmelden</button></td>
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