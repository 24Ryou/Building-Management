<?php
$title = 'Support';
include "header.php";
?>
<div class="container">
    <div class="single-card" id="card-support">
        <div class="card-info">
            <div class="theme-toggler">
                <span class="material-icons-round active">light_mode</span>
                <span class="material-icons-round ">dark_mode</span>
            </div>
            <h2>تماس با پشتیبانی</h2>
            <form action="../includes/mail.inc.php" method="POST">
                <div class="row">
                    <input type="text" name="number" placeholder="شماره همراه خود را وارد کنید">
                </div>
                <div class="row">
                    <textarea name="text">مشکل خود را بنویسید و در آخر گزینه ارسال را بزنید تا درخواست شما برای پشتیبانی ارسال شود</textarea>
                </div>
                <div class="row">
                    <button class="button-primary" type="submit" name="submit">ارسال</button>
                </div>
            </form>
            <div class="bottom">
                <a href="login.php">
                    <h4>عضو هستی؟ ورود</h4>
                </a>
                <a href="signup.php">
                    <h4>عضو نیستی؟ ثبت نام</h4>
                </a>
                <a href="forgot-password.php">
                    <h4>فراموشی رمز عبور</h4>
                </a>
            </div>
        </div>
        <div class="card-photo">
            <a href="https://unsplash.com/photos/5A6FeZONrfk?utm_source=unsplash&utm_medium=referral&utm_content=creditShareLink">
                <span class="material-icons-round">insert_link</span>
            </a> <!-- link -->
            <img src="../data/img/support-min.jpg" alt="">
        </div>
    </div>
</div>
<?php
include_once "footer.php"
?>