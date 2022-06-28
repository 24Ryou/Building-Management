
<?php

include_once '../php/conn.php';
// include_once '../includes/user.inc.php';

$sql = "SELECT * FROM `tran` WHERE username=? ";
// $_SESSION['uhistory-sql'] = $sql;
$ascdesc = "ASC";
if (isset($_GET['sort']) && $_GET['sort'] == 'date')
{   
    $ascdesc = ($_GET['mode'] === 'ASC')? 'DESC' : 'ASC';
    // $sql = "SELECT * FROM `tran` WHERE username=? ORDER BY `tran`.`date` ".$ascdesc.";";
    // $sql = "ORDER BY `tran`.`date` ".$ascdesc.";";
    // $_SESSION['uhistory-sql'] .= $sql;
    if (!empty($_SESSION['uhistory-sql'])) {
        # code...
        $sql .= $_SESSION['uhistory-sql']."ORDER BY `tran`.`date` ".$ascdesc.";";
    }
    else {
        $sql .= "ORDER BY `tran`.`date` ".$ascdesc.";";
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
        $sql .= $_SESSION['uhistory-sql']."ORDER BY `tran`.`price` ".$ascdesc.";";
    }
    else {
        $sql .= "ORDER BY `tran`.`price` ".$ascdesc.";";
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
        $sql .= $_SESSION['uhistory-sql']."ORDER BY `tran`.`info` ".$ascdesc.";";
    }
    else {
        $sql .= "ORDER BY `tran`.`info` ".$ascdesc.";";
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
        $sql .= $_SESSION['uhistory-sql']."ORDER BY `tran`.`date` ".$ascdesc.";";
    }
    else {
        $sql .= "ORDER BY `tran`.`date` ".$ascdesc.";";
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
        $sql .= $_SESSION['uhistory-sql']."ORDER BY `tran`.`price` ".$ascdesc.";";
    }
    else {
        $sql .= "ORDER BY `tran`.`price` ".$ascdesc.";";
    }
}
elseif(isset($_GET['sort']) && $_GET['sort'] == 'infodasc')
{
    $ascdesc = ($_GET['mode'] === 'ASC')? 'DESC' : 'ASC';
    // $sql = "SELECT * FROM `tran` WHERE username=? ORDER BY `tran`.`info` ".$ascdesc.";";
    // $sql = "ORDER BY `tran`.`info` ".$ascdesc.";";
    // $_SESSION['uhistory-sql'] .= $sql;
    if (!empty($_SESSION['uhistory-sql'])) {
        # code...
        $sql .= $_SESSION['uhistory-sql']."ORDER BY `tran`.`info` ".$ascdesc.";";
    }
    else {
        $sql .= "ORDER BY `tran`.`info` ".$ascdesc.";";
    }
}
elseif (isset($_GET['search'])) {
    $query = $_GET['search']; 
    $min_length = 3;
    if(strlen($query) >= $min_length){
        $query = htmlspecialchars($query);
        $query = ($query);
        // $sql = "SELECT * FROM `tran` WHERE `username`=? AND ((`date`LIKE '%$query%') OR (`price` LIKE '%$query%') OR (`info` LIKE '%$query%'));";
        $_SESSION['uhistory-sql'] = "AND ((`date`LIKE '%$query%') OR (`price` LIKE '%$query%') OR (`info` LIKE '%$query%')) ";
        $sql_temp = "SELECT * FROM `tran` WHERE `username`=? AND ((`date`LIKE '%$query%') OR (`price` LIKE '%$query%') OR (`info` LIKE '%$query%'));";
        $stmt = $pdo->prepare($sql_temp);
        if ($stmt->execute([$_SESSION['username']])) {
            # code...
            $sql .= $_SESSION['uhistory-sql'];
        }
        else {
            $_SESSION['uhistory-sql']= null;
        }
    }
}



?>