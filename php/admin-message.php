<?php
$title = "Messages";
include_once 'header.php';
include_once '../includes/getdata.inc.php';
// include_once '../includes/admin2.inc.php';

$_SESSION['tab'] = (empty($_SESSION['tab'])) ? "chat" : $_SESSION['tab'];
?>
<?php
require_once '../includes/functions.inc.php';
if (empty($_SESSION['logged-in'])) {
    header("Location:login.php");
}
?>
<div class="container-admin">
    <header class="admin-header d-flex">
    <?php include_once "admin-profile-card.php"; ?>
        </li>
        <li><a href="admin-dashboard.php">اطلاعات</a></li>
        <li class="selected"><a href="admin-message.php">پیام ها</a></li>
        <!-- <li><a href="admin-setting.php">تنظیمات</a></li> -->
        <li>
            <button class="admin__item admin__item-logout button-danger"><a href="../includes/logout.inc.php">خروج</a></button>
        </li>
    </ul>
    </header>
    <form class="admin-message-card-content d-flex" action="../includes/admin.inc.php" method="POST">
        <div class="admin-message d-column">
            <h4>ارسال به</h4>
            <div class="sendto-radio d-flex">
                <div class="col-6">
                    <input type="radio" name="sendto" value="chats">
                    <label for="sendto">صفحه گفتگو</label>
                </div>
                <div class="col-6">
                    <input type="radio" name="sendto" value="tenant">
                    <label for="sendto">ساکنین</label>
                </div>
            </div>
            <?php dropBoxSelect($pdo); ?>
            <!-- <h4>متن پیام</h4> -->
            <textarea name="text" placeholder="پیام خود را در اینجا بنویسید..."></textarea>
            <div class="file-upload-2">
                <div class="button-wrapper">
                    <span class="label">
                        انتخاب فایل
                    </span>
                    <input type="file" name="upload" id="upload" class="upload-box"
                        placeholder="Upload File">
                </div>
            </div>
            <button class="button-primary" type="submit" name="action" value="send">ارسال</button>
        </div>
        <div id="table-chat"  class="admin-message-tab" action="">
            <ul class="admin-chat d-column">
            <?php include_once '../includes/admin-message.inc.php' ?>
            </ul>
        </div>
        <div id="table-alert" class="admin-message-tab" action="">
            <ul class="admin-alert">
                <li class="admin-alert__item admin-alert_menu d-flex">
                    <div class="admin-alert_menu-checkbox d-flex">
                    <label class="switch payment__input-checkbox">
                        <input type="checkbox" name="readall" value="checked">
                        <span class="slider"></span>
                    </label>
                    <h5>
                        همه رو با عنوان خوانده شده علامت بزن!
                    </h5>
                    </div>
                    <button class="button-nostyle admin-alert_menu-button noletterspace" type="submit" name="action" value="markread">اعمال خواندن</button>
                </li>
                <?php include_once '../includes/admin-alert.inc.php' ?>
            </ul>
        </div>
    </form>
</div>
<?php
include_once 'footer.php';
?>