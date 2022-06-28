<?php
$title = "Payment";
include_once 'header.php';
// include_once '../includes/user.inc.php';
// include_once '../includes/user-message.inc.php';
// include_once '../includes/functions.inc.php';
// include_once '../includes/user-payment2.inc.php';
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
                    <li><a href="user-message.php">پیام ها</a></li>
                    <li class="selected"><a href="user-payment.php">پرداخت</a></li>
                </ul>
                <a href="../includes/logout.inc.php"><button class="signout button-danger">خروج</button></a>
            </div>
        </div>
    </aside>
    <main>
    <?php include_once 'user-price-card.php' ?>
        <form action="../includes/user-payment.inc.php" method="POST">
            <div class="card-payment">
                <div class="info d-flex">
                    <div class="payment__row">
                        <div class="payment__input d-flex">
                            <span class="payment__input-label">پرداخت بدهی</span>
                            <label class="switch payment__input-checkbox">
                                <input type="checkbox" name="chek-debit" value="<?php echo $_SESSION['udebit'] ?>">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="payment__input d-flex">
                            <span class="payment__input-label">پرداخت شارژ</span>
                            <label class="switch payment__input-checkbox">
                                <input type="checkbox"  name="chek-charge" value="<?php echo $_SESSION['ucharge'] ?>">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="payment__input d-flex">
                            <span class="payment__input-label">پرداخت اجاره</span>
                            <label class="switch payment__input-checkbox">
                                <input type="checkbox" name="chek-rent" value="<?php echo $_SESSION['urent'] ?>">
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    <div class="payment__column">
                        <span class="payment__column-label" for="information">توضیحات</span>
                        <textarea class="payment__input-textarea" name="information"  placeholder="توضیحات خود را می توانید در اینجا بنویسید..."  ></textarea>
                    </div>
                    <div class="payment__row d-column">
                        <div class="payment__input payment__input-nostyle payment__input-remember d-flex">
                            <label class="switch payment__input-checkbox">
                                <input type="checkbox" name="chek-credit" value="<?php echo $_SESSION['ucredit'] ?>">
                                <span class="slider"></span>
                            </label>
                            <span class="payment__input-label">اعمال بستانکاری در پرداخت (لطفا در صورت داشتن بستانکاری این گزینه را فعال کنید)</span>
                        </div>
                        <!-- <div>
                            <div class="payment__input-75 payment__input-nostyle">
                                <span class="payment__input-label">هزینه اضافه برای پرداخت</span>
                                <input class="payment__input-number" type="text" name="your-price">
                            </div>
                        </div> -->
                        <div class="payment__input payment__input-nostyle payment__input-remember d-flex">
                            <label class="switch payment__input-checkbox">
                                <input type="checkbox" name="chek-info"value="">
                                <span class="slider"></span>
                            </label>
                            <span class="payment__input-label">اعمال توضیحات پیش فرض!</span>
                        </div>
                    </div>
                    <div class="payment__row gap-1">
                        <div class="payment__input-75 payment__input-nostyle">
                            <span class="payment__input-label">مجموع هزینه ها</span>
                            <input class="payment__input-number" type="text" name="total-price" readonly style="background-color: #777; color:white;" value="<?php 
                            $total = (empty($_SESSION['total-cost'])) ? 0:$_SESSION['total-cost']; 
                            // var_dump($_SESSION['total-cost']);
                            echo $total ?>">
                        </div>
                        <button class="payment__submit button-success" type="submit" name="cal" value="cal">محاسبه</button>
                        <button class="payment__submit button-primary" type="submit" name="pay" value="pay">پرداخت</button>
                    </div>
                </div>
            </div>
        </form>
    </main>
</div>
<?php
include_once 'footer.php';
?>