<?php


include_once 'session.inc.php';
include_once 'functions.inc.php';
include_once '../php/conn.php';

echo '
<!DOCTYPE html>
<html lang="en"dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <title>Test</title>
</head>
<body>
    <div class="testpay d-flex">
        <form action="../includes/user-payment.inc.php" method="POST" class="testpay-form d-column">
            <h1>
                صرفا جهت تست درگاه
            </h1>
            <label for="id">شماره سفارش</label>
            <input type="text" name="" id="" value="'.$_SESSION['new-order'].'">
            <label for="id">مبلغ</label>
            <input type="text" name="" id="" value="'.$_SESSION['total-cost'].'">
            <button class="button-success" type="submit" name="payresult" value="success">پرداخت موفق</button>
            <button class="button-danger" type="submit" name="payresult" value="failed">پرداخت ناموفق</button>
        </form>
    </div>
</body>
</html>
';