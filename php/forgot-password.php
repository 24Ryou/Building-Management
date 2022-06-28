<?php
$title = 'Forgot-password';
include_once "header.php";
?>
<div class="container">
    <div class="single-card" id="card-password">
        <div class="card-info">
            <div class="theme-toggler">
                <span class="material-icons-round active">light_mode</span>
                <span class="material-icons-round ">dark_mode</span>
            </div>
            <h2>رمز خود را فراموش کردید؟</h2>
            <p>اگر رمز خود را فراموش کرده اید شماره همراه که با آن در سیستم ثبت نام کرده اید را وارد کنید تا کد بازیابی برایتان ارسال شود</p>
            <form action="../includes/forgot-pass.inc.php" method="POST">
                <div class="row">
                    <input type="text" name="number" placeholder=" شماره همراه خود را وارد کنید (بدون صفر)">
                    <input type="text" name="codemeli" placeholder="کد ملی خود را وارد کنید">
                    <!-- <button class="code-btn button-danger" type="submit" name="recovey">ارسال کد</button> -->
                </div>
                <div class="row">
                    <input type="text" name="password" placeholder="رمز عبور جدید را وارد کنید">
                    <input type="text" name="password-repeat" placeholder="تکرار رمز عبور">
                    <!-- <button class="code-btn button-danger" type="submit" name="recovey">ارسال کد</button> -->
                </div>
                <div class="row" style="width: 50%;">
                    <button class="button-danger" type="submit" name="submit">تایید</button>
                </div>
            </form>
            <div class="bottom">
                <a href="login.php">
                    <h4>عضو هستی؟ ورورد</h4>
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
            <a href="https://unsplash.com/photos/ww3MV9cGmX8?utm_source=unsplash&utm_medium=referral&utm_content=creditShareLink">
                <span class="material-icons-round">insert_link</span>
            </a> <!-- link -->
            <img src="../data/img/password-min.jpg" alt="">
        </div>
    </div>
</div>
<?php
include_once "footer.php"
?>