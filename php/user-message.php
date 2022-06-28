<?php
$title = "Message";
include_once 'header.php';
include_once '../includes/user2.inc.php';
// include_once '../includes/user.inc.php';
// include_once '../includes/user-message.inc.php';
// include_once '../includes/functions.inc.php';


$_SESSION['tab'] = (empty($_SESSION['tab'])) ? "chat" : $_SESSION['tab'];
// var_dump($_SESSION['testprint']);
?>
<?php
require_once '../includes/functions.inc.php';
if (!$_SESSION['logged-in']) {
    header("Location: login.php");
}
?>
<div class="container-dashboard">
    <aside>
        <div class="sidebar">
        <?php include_once "user-profile-card.php"; ?>
            <div class="menu">
                <ul>
                    <li><a href="user-dashboard.php">اطلاعات کاربر</a></li>
                    <li><a href="user-history.php">تاریخچه</a></li>
                    <li class="selected"><a href="user-message.php">پیام ها</a></li>
                    <li><a href="user-payment.php">پرداخت</a></li>
                </ul>
                <a type="submit" name="logout" href="../includes/logout.inc.php"><button class="signout button-danger">خروج</button></a>
            </div>
        </div>
    </aside>
    <main>
        <?php include_once 'user-price-card.php' ?>
        <form  action="../includes/user.inc.php" method="POST" enctype="multipart/form-data" class="main">
            <div class="card-alert">
                <div class="info-alert d-flex">
                    <div class="message d-column">
                        <h4>ارسال به</h4>
                        <div class="sendto-radio d-flex">
                            <div class="sendto-item d-flex">
                                <input type="radio" name="sendto" value="0">
                                <label for="sendto">صفحه گفتگو</label>
                            </div>
                            <div class="sendto-item d-flex">
                                <input type="radio" name="sendto" value="1">
                                <label for="sendto">مدیریت</label>
                            </div>
                            <div class="sendto-item d-flex">
                                <input type="radio" name="sendto" value="tenant">
                                <label for="sendto">ساکنین</label>
                            </div>
                        </div>
                        
                        <?php dropBoxSelect($pdo); ?>
                        <!-- <h4>متن پیام</h4> -->
                        <textarea name="text" placeholder="پیام خود را در اینجا بنویسید (لطفا به فارسی بنویسید)"></textarea>
                        <div class="" style="width: 100%;">
                            <div class="file-upload-2" style="width: 100%;">
                                <div class="button-wrapper">
                                    <span class="label">
                                        انتخاب فایل
                                    </span>
                                    <input type="file" name="upload-chat-file" id="upload" class="upload-box"
                                        placeholder="Upload File">
                                </div>
                            </div>
                        </div>
                        <button class="button-primary" type="submit" name="send">ارسال</button>
                    </div>
                    <div class="change-tabs d-column">
                        <div class="tab-body d-flex">
                            <ul class="tab d-flex">
                                <li class="tablinks tablinks-firstchild <?php if($_SESSION['tab'] == 'chat'){echo 'activeTab';} ?>"><a href="?tab=chat">صفحه گفتگو</li>
                                <li class="tablinks tablinks-lastchild <?php if($_SESSION['tab'] == 'alert'){echo 'activeTab';} ?>"><a href="?tab=alert">صفحه اعلانات</li>
                            </ul>
                            <!-- <div class="datepicker d-flex">
                                <input class="datepicker-input" name="start-date" type="text" placeholder="از تاریخ" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                                <input class="datepicker-input" name="end-date" type="text" placeholder="تا تاریخ" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}">
                            </div> -->
                        </div>
                        <div class="tabcontent-body">
                            <div class="tabcontent-item">
                                
                                <?php if ($_SESSION['tab'] == 'chat') {
                                    include_once '../includes/user-message.inc.php';
                                } ?>
                                <?php if ($_SESSION['tab'] == 'alert') {
                                    include_once '../includes/user-alert.inc.php';
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>
</div>
<?php
include_once 'footer.php';
?>