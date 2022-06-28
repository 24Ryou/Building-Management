<?php
$title = 'Login';
include_once 'header.php';
?>
<div class="container">
    <div class="single-card" id="card-login">
        <div class="card-info">
            <div class="theme-toggler">
                <span class="material-icons-round active">light_mode</span>
                <span class="material-icons-round ">dark_mode</span>
            </div>
            <h2>خوش آمدید ! <span class="wave">👋🏻</span></h2>
            <form action="../includes/login.inc.php" method="POST">
                <div class="row">
                    <input type="text" name="username" placeholder="نام کاربری خود را وارد کنید (شماره همراه بدون صفر)">
                </div>
                <div class="row">
                    <input type="text" name="password" placeholder="رمز عبور خود را وارد کنید">
                </div>
                <div class="row">
                    <button class="button-primary" type="submit" name="submit">ورود</button>
                </div>
                <!-- php error.inc -->
            </form>
            <div class="bottom">
                <a href="forgot-password.php">
                    <h4>فراموشی رمز عبور</h4>
                </a>
                <a href="signup.php">
                    <h4>عضو نیستی؟ ثبت نام</h4>
                </a>
                <a href="support.php">
                    <h4>هنوز مشکل داری؟ تماس با پشتیبانی</h4>
                </a>
            </div>
        </div>
        <div class="card-photo">
            <a href="https://unsplash.com/photos/xLTbaVPHs3Q?utm_source=unsplash&utm_medium=referral&utm_content=creditShareLink">
                <span class="material-icons-round">insert_link</span>
            </a> <!-- link -->
            <img src="../data/img/login-min.jpg" alt="">
        </div>
    </div>
</div>
<?php
include_once 'footer.php'
?>