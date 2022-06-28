<?php

include_once 'session.inc.php';
include_once "../php/conn.php";
include_once 'functions.inc.php';
include_once 'jdf.php';

$username = $_SESSION['username'];

$stmt = $pdo->prepare("SELECT * FROM account WHERE ac_username=?;");
$stmt->execute([$username]);
$data = $stmt->fetch();
$filename = "../data/users/".$username."/contract.jpg";
if (empty($data['ac_codemelli'])) {
    $msg = "کد ملی وارد نشده! برای بازیابی رمز داشتن کد ملی ضروری است!";
    $sender = 2;
    $reciever = $username;
    $verify = 0;
    $file = 0;
    $date = jdate('Y-m-d H:i:s',time(),'','Asia/Tehran','en');
    $pdo->prepare("INSERT INTO `message`(sender,receiver,`text`,`file`,`date`,verify) VALUES(?,?,?,?,?,?);")->execute([$sender,$reciever,$msg,$file,$date,$verify]);
}

if (!file_exists($filename)) {
    $msg = "عکس قرار داد وارد سیستم نشده!";
    $sender = 2;
    $reciever = $username;
    $verify = 0;
    $file = 0;
    $date = jdate('Y-m-d H:i:s',time(),'','Asia/Tehran','en');
    $pdo->prepare("INSERT INTO `message`(sender,receiver,`text`,`file`,`date`,verify) VALUES(?,?,?,?,?,?);")->execute([$sender,$reciever,$msg,$file,$date,$verify]);

}