<?php
require_once '../php/conn.php';
require_once 'functions.inc.php';

if (isset($_POST['submit'])) {
    # code...
    $phone = $_POST['number'];
    $codemeli = $_POST['codemeli'];
    $pwd = $_POST['password'];
    $pwdrepeat = $_POST['password-repeat'];

    if ($row = phoneExists($pdo,$phone)) {
        # code...
        if ($codemeli == $row['ac_codemelli']) {
            # code...
            if (strlen($pwd) >= 6)  {
                # code...
                if ($pwd == $pwdrepeat) {
                    # code...
                    $pwdhashed = password_hash($pwd,PASSWORD_DEFAULT);
                    $sql  = 'UPDATE `account` SET `ac_password`=? WHERE ac_username = ?;';
                    $stmt = $pdo->prepare($sql);
                    if ($stmt->execute([$pwdhashed,$phone])) {
                        # code...
                        echo '<script>window.alert("رمز عبور جدید شما با موفقیت ثبت شد!")</script>';
                    }
                    else {
                        echo '<script>window.alert("سیستم با خطا مواجه شد با پشتیبانی تماس بگیرید!")</script>';
                    }
                }
                else {
                    echo '<script>window.alert("تکرار رمز عبور اشتباه است!")</script>';
                }
            }
            else {
                echo '<script>window.alert("رمز عبور حداقل باید 6 حرف باشد")</script>';
            }
        }
        else {
            echo '<script>window.alert("کاربری با این کد ملی در سیستم ثبت نشده است.!")</script>';
        }
    }
    else {
        echo '<script>window.alert("کاربری با این شماره در سیستم وجود ندارد!!")</script>';
    }
    echo ("<script type='text/javascript'>
            location.replace(\"/building-managment/\");
            </script>");
    
}