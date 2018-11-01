<?php
session_start();

if(!isset($_SESSION["user_id"])):
    header("Location: ../../index.php?info=8");
elseif($_SESSION["user_status"] != "admin"):
    header("Location: ../../index.php?info=9");
endif;
?>
<div class="logo">
	<a href="<?=$domain?>" class="simple-text logo-mini">-</a>
	<a href="<?=$domain?>" class="simple-text logo-normal">eSport Events</a>
</div>

<div class="sidebar-wrapper">
	<div class="user">
		<div class="photo"><img src="<?=$domain?>templates/assets/img/avatar_placeholder.png" /></div>
		<div class="info">
        	<a data-toggle="collapse" href="#collapseExample" class="collapsed">
				<span><?=$_SESSION["user_name"]?> <b class="caret"></b></span>
			</a>
			<div class="clearfix"></div>
			<div class="collapse" id="collapseExample">
				<ul class="nav">
                	<li>
                    	<a href="<?=$domain?>user/profile.php">
                        	<span class="sidebar-mini"><i class="material-icons">account_circle</i></span>
							<span class="sidebar-normal"> Mein Profil </span>
						</a>
                    </li>
                    <li>
			            <a href="<?=$domain?>user/edit-profile.php">
                        	<span class="sidebar-mini"><i class="material-icons">edit</i></span>
                            <span class="sidebar-normal"> Profil bearbeiten </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <ul class="nav">
		<li class="<?php if ($pageKey == 'admin_dashboard') { echo 'active'; } ?>">
			<a href="<?=$domain?>admin/dashboard.php">
            	<i class="material-icons">dashboard</i>
                <p> Dashboard </p>
            </a>
        </li>
		<li class="<?php if ($pageKey == 'turniererstellung') { echo 'active'; } ?>">
        	<a href="<?=$domain?>admin/turniererstellung/index.php">
                <i class="material-icons">add_circle</i>
                <p> Turniererstellung </p>
            </a>
        </li>
        <li class="<?php if ($pageKey == 'turnierverwaltung') { echo 'active'; } ?>">
            <a href="<?=$domain?>admin/turnierverwaltung/index.php">
                <i class="material-icons">content_paste</i>
                <p> Turnierverwaltung </p>
        	</a>
        </li>
        <li class="<?php if ($pageKey == 'sgsd') { echo 'active'; } ?>">
            <a href="<?=$domain?>admin/users.php">
                <i class="material-icons">people</i>
                <p> Mitgliederübersicht </p>
       	 	</a>
        </li>
        <li>
            <a href="<?=$domain?>logout.php">
                <i class="material-icons">cancel</i>
                <p> Logout </p>
            </a>
        </li>
    </ul>
</div>