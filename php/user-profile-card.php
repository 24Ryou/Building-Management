<div class="profile">
    <div class="top">
        <div class="notfication">
        <a href="user-message.php?tab=alert">
            <span class="material-icons-round">notifications</span>
            <?php if ($_SESSION['notfBadge'] != 0) {
                    echo '<span class="badge">'.$_SESSION['notfBadge'].'</span>';
                } ?>
                </a>
        </div>
        <span class="photo-circle">
            <?php echo "<img src=" . $_SESSION["uprofile"] . ">" ?>
        </span>
        <div class="theme-toggler">
            <span class="material-icons-round active">light_mode</span>
            <span class="material-icons-round ">dark_mode</span>
        </div>
    </div><?php echo  '<h5>' . $_SESSION['ufirstname'] . " " . $_SESSION['ulastname'] . '</h5>' ?>
</div>