<?php

include_once 'session.inc.php';
include_once 'functions.inc.php';
include_once '../php/conn.php';
include_once 'jdf.php';


// $_SESSION['pay-info'] = "";
// $_SESSION['pay-info'] = ($_SESSION['pay-info'] != "") ? $_SESSION['pay-info']:"";
// $_SESSION['total-cost'] = "";
// $_SESSION['total-cost'] = ($_SESSION['total-cost'] != "") ? $_SESSION['total-cost']:"";

if (isset($_POST['cal'])) {
    // echo 'its here';
    # code...;
    $rent = ($_POST['chek-rent'])? $_SESSION['urent'] : '0';
    $charge = ($_POST['chek-charge']) ? $_SESSION['ucharge'] : '0';
    $debit = ($_POST['chek-debit']) ? $_SESSION['udebit'] : '0';
    $credit = ($_POST['chek-credit']) ? $_SESSION['credit'] : '0';
    $info = $_POST['information'];
    $a = array();
    $total = 0;

    $username = $_SESSION['username'];
    

    $sql ="SELECT * FROM `account` WHERE ac_username = ?;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $row = $stmt->fetch();

    if ($rent != '0') {
        # code...
        $_SESSION['chek-rent'] = 'checked';
        $rent = $row['ac_rent'];
        array_push($a,'پرداخت اجاره');
        $total = $total + (int)$rent;
    }
    if ($charge != '0') {
        # code...
        $_SESSION['chek-charge'] = 'checked';
        $charge = $row['ac_charge'];
        array_push($a,'پرداخت شارژ');
        $total = $total + (int)$charge;
    }
    if ($debit != '0') {
        # code...
        $_SESSION['chek-debit'] = 'checked';
        $debit = $row['ac_debit'];
        array_push($a,'پرداخت بدهی');
        $total = $total + (int)$debit;
    }
    if ($credit != '0') {
        # code...
        $_SESSION['chek-credit'] = 'checked';
        $credit = $row['ac_credit'];
        $total = $total - (int)$credit;
    }

    if ($total < 0) {
        # code...
        $credit = abs($total);
        $total = 0;
    }


    if (count($a) == 0) {
        # code...
        $info .= "";
    }
    if (count($a) == 1) {
        # code...
        $info .= (string)array_pop($a);
    }
    if (count($a) > 1) {
        # code...
        for ($x = 0; $x < count($a); $x++){
            $info .= (string)array_pop($a);
            $info .= " و ";
        }
        $info .= (string)array_pop($a);
    }
    
    $_SESSION['pay-info'] = $info;
    $_SESSION['total-cost'] = (string)$total;
    $_SESSION['newurent'] = $rent;
    $_SESSION['newucharge'] = $charge;
    $_SESSION['newudebit'] = $debit;
    $_SESSION['newucredit'] = $credit;
    // var_dump($rent);
    // var_dump($charge);
    // var_dump($credit);
    // var_dump($debit);
    // var_dump($total);
    // var_dump($_SESSION['total-cost']);
    // var_dump($total);
    header('location: ../php/user-payment.php');
    exit();
}

if (isset($_POST['pay'])) {
    $time = jdate('Y-m-d H:i:s',time(),'','Asia/Tehran','en');
    $time = date('Y-m-d H:i:s',strtotime($time));
    $_SESSION['order-time'] = $time;
    $verify = 'در انتظار پرداخت';
    $sql = "INSERT INTO `orders`(order_time,order_total_price,order_verify) VALUES(?,?,?); ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$time,$_SESSION['total-cost'],$verify]);
    $_SESSION['new-order'] = $pdo->lastInsertId();

    header('location:testpay-inc.php');
}

if (isset($_POST['payresult'])) {
    # code...
    if ($_POST['payresult'] == 'success') {
        # code...
        $sql = "UPDATE `orders` SET order_verify=? WHERE order_id=? ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['پرداخت موفق',$_SESSION['new-order']]);
        // $sql = "UPDATE `account` SET ac_rent=?, ac_charge=?, ac_debit=?, ac_credit=? WHERE ac_username = ? ";
        // $stmt = $pdo->prepare($sql);
        // $stmt->execute([$_SESSION['newurent'],$_SESSION['newucharge'],$_SESSION['newudebit'],$_SESSION['newucredit'],$_SESSION['username']]);
        $sql = "INSERT INTO `tran`(username,orders,price,info,`date`) VALUES(?,?,?,?,?); ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['username'],$_SESSION['new-order'],$_SESSION['total-cost'],$_SESSION['pay-info'],$_SESSION['order-time']]);
        $_SESSION['total-cost'] = '0';
    }
    if ($_POST['payresult'] == 'failed') {
        # code...
        $sql = "UPDATE `orders` SET order_verify=? WHERE order_id = ?;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['پرداخت ناموفق',$_SESSION['new-order']]); 
        $sql = "INSERT INTO `tran`(username,orders,price,info,`date`) VALUES(?,?,?,?,?); ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['username'],$_SESSION['new-order'],$_SESSION['total-cost'],$_SESSION['pay-info'],$_SESSION['order-time']]);
    
    }
    
    header('location: ../php/user-payment.php');
    exit();
}
