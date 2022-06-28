<?php
$title = "History";
include_once 'header.php';
// var_dump($_SESSION['uhistory-sql']);
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
                    <li class="selected"><a href="user-history.php">تاریخچه</a></li>
                    <li><a href="user-message.php">پیام ها</a></li>
                    <li><a href="user-payment.php">پرداخت</a></li>
                </ul>
                <a href="../includes/logout.inc.php"><button class="signout button-danger">خروج</button></a>
            </div>
        </div>
    </aside>
    <main>
        <?php include_once 'user-price-card.php' ?>
        <form  action="" method="GET" class="main">
            <div class="card-history">
                <div class="info">
                    <input type="text" id="myInput" type="search" name="search" placeholder="جستجو....(لطفا کمتر از 3 حرف نباشد)" style="text-align: right; direction: rtl;">
                    <div class="table-body">
                        <!-- <table class="table">
                            <thead> -->
                                <!-- <tr>
                                    <th><a href="?sort=date&mode=<?php echo $ascdesc?>">تاریخ پرداخت</a></th>
                                    <th><a href="?sort=price&mode=<?php echo $ascdesc?>">قیمت</a></th>
                                    <th><a href="?sort=info&mode=<?php echo $ascdesc?>">توضیحات</a></th>
                                </tr>
                            </thead>
                            <tbody> -->
                            <?php 
                            include_once '../includes/functions.inc.php';
                            
                            include_once '../includes/user-history.inc.php'
                            // showUserHistoryData($pdo,$_SESSION['username'],$sql,$ascdesc)?>
                            <!-- </tbody>
                        </table> -->
                    </div>
                </div>
            </div>
        </form>
    </main>
</div>
<?php
include_once 'footer.php';
?>