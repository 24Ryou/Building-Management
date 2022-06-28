<?php
    include_once '../includes/user.inc.php';
    include_once '../includes/session.inc.php';
    include_once '../includes/functions.inc.php';
?>
<ul class="admin-menu2 d-flex">
    <li>
        <div class="admin__item admin-profile d-flex">
            <div class="admin-profile__item">
                <div class="theme-toggler theme-toggler-admin">
                    <span class="material-icons-round active">light_mode</span>
                    <span class="material-icons-round ">dark_mode</span>
                </div>
            </div>
            <span class="admin-profile__item admin--photo-backgroud">
                <!-- <img class="admin__item-photo" src="img/profile-3.jpg"> -->
                <a href="?tab=profile"><?php echo '<img class="admin__item-photo" src="' . $_SESSION['uprofile'] . '">';?></a>
            </span>
            <div class="admin-profile__item d-flex">
                <span class="admin-profile__item-welcome">
                    <p>سلام، <b><?php echo $_SESSION['ufirstname'] ?></b></p>
                    <small class="text-muted">ادمین</small>
                </span>
            </div>
            <a href="admin-message.php" class="notfication">
                <span class="material-icons-round bell">
                    notifications
                </span>
                <?php if ($_SESSION['notfBadge'] != 0) {
                    echo '<span class="badge">'.$_SESSION['notfBadge'].'</span>';
                } ?>
            </a>
        </div>