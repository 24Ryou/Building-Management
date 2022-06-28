<?php
$title = 'Dashboard';
include_once 'header.php';
include_once '../includes/user.inc.php';
include_once '../includes/getdata.inc.php';
?>
<?php
require_once '../includes/functions.inc.php';
if (!$_SESSION['logged-in']) {
    header("Location: login.php");
}
?>
<form action="../includes/user.inc.php" method="POST" enctype="multipart/form-data" class="main" id="form1">
    <div class="container-dashboard">
        <aside>
            <div class="sidebar">
                <?php include_once "user-profile-card.php"; ?>
                <div class="menu">
                    <ul>
                        <li class="selected"><a href="user-dashboard.php">اطلاعات کاربر</a></li>
                        <li><a href="user-history.php">تاریخچه</a></li>
                        <li><a href="user-message.php">پیام ها</a></li>
                        <li><a href="user-payment.php">پرداخت</a></li>
                    </ul>
                    <div class="buttons">
                        <button type="submit" name="action" value="save" class="button-success save" >ثبت تغیرات</button>
                        <button type="submit" name="action" value="logout" class="signout button-danger">خروج</button>
                    </div>
                </div>
            </div>
        </aside>
        <main class="main">
            <?php include_once "user-price-card.php" ?>
            <div>
                <div class="card-user">
                    <div class="info">
                        <h4>اطلاعات شخصی<h4>
                        <div class="personal">
                            <div id="form" >
                                <div class="col-3">
                                    <div class="form-field">
                                        <label for="fname">نام</label>
                                        <input type="text" name="fname" value="<?php echo $_SESSION['ufirstname'] ?>">
                                    </div>
                                    <div class="form-field">
                                        <label for="age">سن</label>
                                        <div class="age">
                                            <input type="text" name="age" value="<?php echo $_SESSION['uage'] ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-field">
                                        <label for="lname">نام خانوادگی</label>
                                        <input type="text" name="lname" value="<?php echo $_SESSION['ulastname']  ?>">
                                    </div>
                                    <div class="form-field">
                                        <label class="" for="gender">جنسیت</label>
                                        <div class="gender-radio">
                                            <!-- <input type="radio" name="gender" value="1">
                                            <label for="gender">مرد</label>
                                            <input type="radio" name="gender" value="2">
                                            <label for="gender">زن</label> -->
                                            <?php insertRadioGender() ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-field">
                                        <label for="code-meli">کد ملی</label>
                                        <input type="text" name="code-meli" value="<?php echo $_SESSION['uid'] ?>">
                                    </div>
                                    <div class="form-field field-number">
                                        <label for="number">شماره همراه</label>
                                        <input class="not-editable" type="text" name="number" readonly value="<?php echo $_SESSION['uphone'] ?>">
                                        <!-- <span class="material-icons-sharp">edit</span> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4>اطلاعات واحد<h4>
                        <div class="apartment">
                            <div id="form">
                                <div class="col-3 space-between">
                                    <div class="form-field">
                                        <label for="apartment-id">شماره واحد</label>
                                        <!-- <div class="custom-select">
                                <select name="apartment-id" >
                                    <option class="select-items" value="0"></option>
                                </select>
                            </div> -->
                                        <div class="age">
                                            <input type="text" name="apartment-id" value="<?php echo $_SESSION['uapartment'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-field field-number">
                                        <label for="power-id">شناسه آب</label>
                                        <input class="not-editable" type="text" name="water-id" readonly value="<?php echo $_SESSION['uwaterid'] ?>">
                                    </div>
                                </div>
                                <div class="col-3 space-between">
                                    <div class="form-field">
                                        <label for="apartment-people">تعداد افراد واحد</label>
                                        <div class="custom-select">
                                            <!-- <select name="apartment-id">
                                    <option class="select-items" value="0"></option>
                                </select> -->
                                            <div class="age">
                                                <input type="text" name="apartment-people" value="<?php echo $_SESSION['upeople'] ?> ">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-field field-number">
                                        <label for="gas-id">شناسه برق</label>
                                        <input class="not-editable" type="text" name="power-id" readonly value="<?php echo $_SESSION['upowerid'] ?>">
                                    </div>
                                </div>
                                <div class="col-3 space-between">
                                    <div class="form-field">
                                        <label for="contract">عکس قرارداد</label>
                                        <div class="file-upload-user">
                                            <div class="file-upload-2">
                                                <div class="button-wrapper">
                                                    <span class="label">
                                                        jpg. انتخاب فایل
                                                    </span>
                                                    <input type="file" name="upload-contract" id="upload" class="upload-box" placeholder="Upload File">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-field field-number">
                                        <label for="water-id">شناسه گاز</label>
                                        <input class="not-editable" type="text" name="gas-id" readonly value="<?php echo $_SESSION['ugasid'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4>اطلاعات حساب</h4>
                        <div class="account">
                            <div id="form">
                                <div class="col-3">
                                    <div class="form-field field-number">
                                        <label for="password">رمز عبور جدید</label>
                                        <input type="text" name="password">
                                        <!-- <span class="material-icons-sharp">edit</span> -->
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-field field-number">
                                        <label for="password-repeat">تکرار رمز عبور</label>
                                        <input type="text" name="password-repeat">
                                        <!-- <span class="material-icons-sharp">edit</span> -->
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-field">
                                        <label for="profile-photo">عکس پروفایل</label>
                                        <div class="file-upload-user">
                                            <div class="file-upload-2">
                                                <div class="button-wrapper">
                                                    <span class="label">
                                                        jpg. انتخاب فایل
                                                    </span>
                                                    <input type="file" name="upload-profile" id="upload" class="upload-box" placeholder="Upload File" value="<?php echo "" ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</form>
<?php
include_once 'footer.php'
?>