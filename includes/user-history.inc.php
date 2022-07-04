
<?php

include_once '../php/conn.php';
include_once 'functions.inc.php';
// include_once '../includes/user.inc.php';
$usernameID = $_SESSION['username'];
$sql = "SELECT * FROM `tran` INNER JOIN `orders` ON `tran`.orders = `orders`.order_id WHERE username=$usernameID ";
$_SESSION['uhistory-sql'] = $sql;
$ascdesc = "ASC";
if (isset($_GET['sort']) && $_GET['sort'] == 'date')
{   
    $ascdesc = ($_GET['mode'] === 'ASC')? 'DESC' : 'ASC';
    // $sql = "SELECT * FROM `tran` WHERE username=? ORDER BY `tran`.`date` ".$ascdesc.";";
    // $sql = "ORDER BY `tran`.`date` ".$ascdesc.";";
    // $_SESSION['uhistory-sql'] .= $sql;
    if (!empty($_SESSION['uhistory-sql'])) {
        # code...
        $sql = $_SESSION['uhistory-sql']."ORDER BY `tran`.`date` ".$ascdesc.";";
    }
    else {
        $sql = "ORDER BY `tran`.`date` ".$ascdesc.";";
    }
}
elseif (isset($_GET['sort']) && $_GET['sort'] == 'price')
{
    $ascdesc = ($_GET['mode'] === 'ASC')? 'DESC' : 'ASC';
    // $sql = "SELECT * FROM `tran` WHERE username=? ORDER BY `tran`.`price` ".$ascdesc.";";
    // $sql = "ORDER BY `tran`.`price` ".$ascdesc.";";
    // $_SESSION['uhistory-sql'] .= $sql;
    if (!empty($_SESSION['uhistory-sql'])) {
        # code...
        $sql = $_SESSION['uhistory-sql']."ORDER BY `tran`.`price` ".$ascdesc.";";
    }
    else {
        $sql = "ORDER BY `tran`.`price` ".$ascdesc.";";
    }
}
elseif (isset($_GET['sort']) && $_GET['sort'] == 'info')
{
    $ascdesc = ($_GET['mode'] === 'ASC')? 'DESC' : 'ASC';
    // $sql = "SELECT * FROM `tran` WHERE username=? ORDER BY `tran`.`info` ".$ascdesc.";";
    // $sql = "ORDER BY `tran`.`info` ".$ascdesc.";";
    // $_SESSION['uhistory-sql'] .= $sql;
    if (!empty($_SESSION['uhistory-sql'])) {
        # code...
        $sql = $_SESSION['uhistory-sql']."ORDER BY `tran`.`info` ".$ascdesc.";";
    }
    else {
        $sql = "ORDER BY `tran`.`info` ".$ascdesc.";";
    }
}
elseif (isset($_GET['sort']) && $_GET['sort'] == 'status')
{
    $ascdesc = ($_GET['mode'] === 'ASC')? 'DESC' : 'ASC';
    // $sql = "SELECT * FROM `tran` WHERE username=? ORDER BY `tran`.`info` ".$ascdesc.";";
    // $sql = "ORDER BY `tran`.`info` ".$ascdesc.";";
    // $_SESSION['uhistory-sql'] .= $sql;
    if (!empty($_SESSION['uhistory-sql'])) {
        # code...
        $sql = $_SESSION['uhistory-sql']."ORDER BY `order_verify` ".$ascdesc.";";
    }
    else {
        $sql = "ORDER BY `order_verify` ".$ascdesc.";";
    }
}
elseif(isset($_GET['sort']) && $_GET['sort'] == 'dateasc')
{
    $ascdesc = ($_GET['mode'] === 'ASC')? 'DESC' : 'ASC';
    // $sql = "SELECT * FROM `tran` WHERE username=? ORDER BY `tran`.`date` ".$ascdesc.";";
    // $sql = "ORDER BY `tran`.`date` ".$ascdesc.";";
    // $_SESSION['uhistory-sql'] .= $sql;
    if (!empty($_SESSION['uhistory-sql'])) {
        # code...
        $sql = $_SESSION['uhistory-sql']."ORDER BY `tran`.`date` ".$ascdesc.";";
    }
    else {
        $sql = "ORDER BY `tran`.`date` ".$ascdesc.";";
    }
}
elseif(isset($_GET['sort']) && $_GET['sort'] == 'priceasc')
{
    $ascdesc = ($_GET['mode'] === 'ASC')? 'DESC' : 'ASC';
    // $sql = "SELECT * FROM `tran` WHERE username=? ORDER BY `tran`.`price` ".$ascdesc.";";
    // $sql = "ORDER BY `tran`.`price` ".$ascdesc.";";
    // $_SESSION['uhistory-sql'] .= $sql;
    if (!empty($_SESSION['uhistory-sql'])) {
        # code...
        $sql = $_SESSION['uhistory-sql']."ORDER BY `tran`.`price` ".$ascdesc.";";
    }
    else {
        $sql = "ORDER BY `tran`.`price` ".$ascdesc.";";
    }
}
elseif(isset($_GET['sort']) && $_GET['sort'] == 'infoasc')
{
    $ascdesc = ($_GET['mode'] === 'ASC')? 'DESC' : 'ASC';
    // $sql = "SELECT * FROM `tran` WHERE username=? ORDER BY `tran`.`info` ".$ascdesc.";";
    // $sql = "ORDER BY `tran`.`info` ".$ascdesc.";";
    // $_SESSION['uhistory-sql'] .= $sql;
    if (!empty($_SESSION['uhistory-sql'])) {
        # code...
        $sql = $_SESSION['uhistory-sql']."ORDER BY `tran`.`info` ".$ascdesc.";";
    }
    else {
        $sql = "ORDER BY `tran`.`info` ".$ascdesc.";";
    }
}
elseif(isset($_GET['sort']) && $_GET['sort'] == 'statusasc')
{
    $ascdesc = ($_GET['mode'] === 'ASC')? 'DESC' : 'ASC';
    // $sql = "SELECT * FROM `tran` WHERE username=? ORDER BY `tran`.`info` ".$ascdesc.";";
    // $sql = "ORDER BY `tran`.`info` ".$ascdesc.";";
    // $_SESSION['uhistory-sql'] .= $sql;
    if (!empty($_SESSION['uhistory-sql'])) {
        # code...
        $sql = $_SESSION['uhistory-sql']."ORDER BY `tran`.`order_verify` ".$ascdesc.";";
    }
    else {
        $sql = "ORDER BY `tran`.`order_verify` ".$ascdesc.";";
    }
}
elseif (isset($_GET['search'])) {
    $query = $_GET['search']; 
    $min_length = 3;
    if(strlen($query) >= $min_length){
        $query = htmlspecialchars($query);
        $query = ($query);
        // $sql = "SELECT * FROM `tran` WHERE `username`=? AND (`date`LIKE '%$query%') OR (`price` LIKE '%$query%') OR (`info` LIKE '%$query%'));";
        $_SESSION['uhistory-sql'] .= "AND ((`date`LIKE '%$query%') OR (`price` LIKE '%$query%') OR (`info` LIKE '%$query%')) ";
        $sql_temp = "SELECT * FROM `tran` WHERE `username`=? AND ((`date`LIKE '%$query%') OR (`price` LIKE '%$query%') OR (`info` LIKE '%$query%'));";
        $stmt = $pdo->prepare($sql_temp);
        if ($stmt->execute([$_SESSION['username']])) {
            # code...
            $sql = $_SESSION['uhistory-sql'];
        }
        else {
            $_SESSION['uhistory-sql']= null;
        }
    }
}



?>
<table class="table">
    <thead>
        <tr>
            <th><a href="?sort=date&mode=<?php echo $ascdesc?>">تاریخ پرداخت</a></th>
            <th><a href="?sort=price&mode=<?php echo $ascdesc?>">قیمت</a></th>
            <th><a href="?sort=info&mode=<?php echo $ascdesc?>">توضیحات</a></th>
            <th><a href="?sort=status&mode=<?php echo $ascdesc?>">وضعیت پرداخت</a></th>
        </tr>
</thead>
<tbody>
<?php
$stmt = $pdo->prepare($sql);
$stmt->execute();
while($row = $stmt->fetch()) : 
        $status = $row['order_verify'];
    if ($status == 'منقضی شد') {
        echo '
        <tr>
            <td style="direction:ltr">'. $row['date'].' </td>
            <td>'. number_format($row['price']).'  تومان</td>
            <td>'. $row['info'].' </td>
            <td class="expired">'. $status.' </td>
        </tr>
        ';
    }
    if ($status == 'پرداخت موفق') {
        echo '
        <tr>
            <td style="direction:ltr">'. $row['date'].' </td>
            <td>'. number_format($row['price']).'  تومان</td>
            <td>'. $row['info'].' </td>
            <td class="success">'. $status.' </td>
        </tr>
        ';
    }
    if ($status == 'پرداخت ناموفق') {
        echo '
        <tr>
            <td style="direction:ltr">'. $row['date'].' </td>
            <td>'. number_format($row['price']).'  تومان</td>
            <td>'. $row['info'].' </td>
            <td class="failed">'. $status.' </td>
        </tr>
        ';
    }
    if ($status == 'در انتظار پرداخت') {
        echo '
        <tr>
            <td style="direction:ltr">'. $row['date'].' </td>
            <td>'. number_format($row['price']).'  تومان</td>
            <td>'. $row['info'].' </td>
            <td class="warning">'. $status.' </td>
        </tr>
        ';
    }
    
        
endwhile;
?>

</tbody>
</table>
