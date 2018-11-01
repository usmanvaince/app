<?php
session_start();
error_reporting(0);

### Wartungsmodus der Seite ein-/abschalten ###
$wartungsmodus = 2;

if ($_SESSION["user_status"] == "ban"):
    header("Location: " . $domain . "error/gebannt.php");
elseif ($wartungsmodus == 1):
    header("Location: " . $domain . "error/wartungsmodus.php");
endif;

mysqli_query($connection, "UPDATE fifa_user SET logtime = '$time' WHERE user_id = '" . $_SESSION["user_id"] . "'");
?>
<html class="full">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>
    <meta name="viewport" content="width=device-width"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

    <title>App eSport Events</title>

    <link href="<?php echo $domain; ?>/images/favicon.ico" rel="shortcut icon" type="image/x-icon"/>

    <!-- Bootstrap core CSS     -->
    <link href="<?php echo $domain; ?>templates/assets/css/bootstrap.min.css" rel="stylesheet"/>

    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link href="<?php echo $domain; ?>templates/css/fontawesome-all.css" rel="stylesheet"/>
    <link href="<?php echo $domain; ?>templates/jcountdown/jcountdown.css" rel="stylesheet"/>

    <link href="<?php echo $domain; ?>templates/assets/css/main.css" rel="stylesheet" type="text/css">

    <?php if ($pageKey == 'register') { ?>
        <script src='https://www.google.com/recaptcha/api.js'></script>
    <?php } ?>
</head>
<body>

<header class="header">
    <div class="container-fluid clearfix">
        <div id="logo">
            <a href="<?php echo $domain; ?>">
                <svg width="80px" height="80px" viewBox="0 0 80 80" style="width:80px;height:80px;">
                    <path fill="#FFD600" d="M68.285,11.715c-15.623-15.62-40.948-15.62-56.569,0c-15.62,15.623-15.62,40.948,0,56.571
	c15.622,15.618,40.946,15.618,56.569,0C83.905,52.663,83.905,27.338,68.285,11.715z M59.602,25.892
	c-1.517,1.515-3.978,1.515-5.493,0c-7.778-7.781-20.437-7.784-28.217,0c-7.781,7.778-7.781,20.438,0,28.215
	c7.78,7.785,20.438,7.783,28.217,0c1.516-1.514,3.977-1.514,5.493,0c1.516,1.52,1.516,3.98,0,5.496
	c-5.406,5.404-12.503,8.104-19.6,8.104c-7.102,0-14.2-2.7-19.603-8.104c-10.809-10.81-10.809-28.395,0-39.202
	c10.807-10.808,28.39-10.811,39.202,0C61.117,21.916,61.117,24.375,59.602,25.892z M60.057,40c0,2.143-1.739,3.883-3.883,3.883
	h-24.33c-2.146,0-3.881-1.74-3.881-3.883c0-2.146,1.735-3.882,3.881-3.882h24.33C58.317,36.118,60.057,37.854,60.057,40z"/>
                </svg>

            </a>
        </div>
        <div class="text_header">
            <h1><span>esport</span> event gmbh</h1>
        </div>
        <div class="right">
            <?php
            if (isset($_SESSION['user_id']) && $_SESSION['user_status'] == 'admin') {
            ?>
                <a class="button" href="<?php echo $domain; ?>admin/dashboard.php">Dashboard</a>
            <?php
            } elseif (isset($_SESSION['user_id']) && $_SESSION['user_status'] != 'admin') {
            ?>
                <a class="button" href="<?php echo $domain; ?>user/dashboard.php">Dashboard</a>
            <?php
            } else {
            ?>
                <a href="<?php echo $domain; ?>register.php" class="register">Keinen Account?</a>
                <a class="button" href="<?php echo $domain; ?>login.php">Login</a>
            <?php
            }
            ?>
        </div>
    </div>
</header>
