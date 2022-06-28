<?php
$title = 'signup';
include_once 'header.php';
?>
<div class="container">
    <div class="single-card" id="card-signup">
        <div class="card-info">
            <div class="theme-toggler">
                <span class="material-icons-round active">light_mode</span>
                <span class="material-icons-round ">dark_mode</span>
            </div>
            <h2>ثبت نام</h2>
            <form action="../includes/signup.inc.php" method="POST">
                <div class="row">
                    <input type="text" name="firstname" placeholder="نام (فارسی)">
                    <input type="text" name="lastname" placeholder="نام خانوادگی (فارسی)">
                </div>
                <div class="row">
                    <input type="password" name="password" placeholder="رمز عبور حداقل شامل 6 حروف باشد">
                    <input type="password" name="passwordrepeat" placeholder="تکرار رمز عبور">
                </div>
                <div class="row">
                    <input class="signup-number" type="text" name="phone" placeholder="شماره همراه را بدون صفر وارد کنید">
                    <button class="button-success" type="submit" name="submit">ثبت نام</button>
                </div>
                <!-- php error.inc -->
            </form>
            <div class="bottom">
                <a href="forgot-password.php">
                    <h4>فراموشی رمز عبور</h4>
                </a>
                <a href="login.php">
                    <h4>عضو هستی؟ ورود</h4>
                </a>
                <a href="support.php">
                    <h4>هنوز مشکل داری؟ تماس با پشتیبانی</h4>
                </a>
            </div>
        </div>
        <div class="card-photo">
            <a href="https://unsplash.com/photos/Jp3OEDO4Q-8?utm_source=unsplash&utm_medium=referral&utm_content=creditShareLink">
                <span class="material-icons-round">insert_link</span></a> <!-- link -->
            <img src="../data/img/signup-min.jpg" alt="">
        </div>
    </div>
</div>
<?php
include_once 'footer.php'
?>