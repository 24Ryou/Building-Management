<?php

include_once '../php/conn.php';
include_once 'functions.inc.php';
include_once 'session.inc.php';

if (isset($_GET['search'])) {
    $query = $_GET['search']; 
    $min_length = 3;
    if(strlen($query) >= $min_length){
        $query = htmlspecialchars($query);
        $query = ($query);
        $sql_temp = "SELECT * FROM `tran` WHERE `username`=? AND ((`date`LIKE '%$query%') OR (`price` LIKE '%$query%') OR (`info` LIKE '%$query%'));";
        $stmt = $pdo->prepare($sql_temp);
        if ($stmt->execute([$_SESSION['username']])) {
            # code...
            $sql = $sql_temp;
            $_SESSION['uhistory-sql'] = $sql;
        }
    }
}
