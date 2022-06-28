<?php
 include_once '../php/conn.php';
 $sql = "SELECT ac_password FROM account;";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$pwds = (array) null;
while($row = $stmt->fetchColumn()){
    // $hashed_password = password_hash($row,PASSWORD_DEFAULT);
    // $sql = "UPDATE account SET ac_password=:pwd;";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute([$hashed_password]);
    // echo $row."\t".$hashed_password."<br>";
    array_push($pwds,$row);
}
 $sql = "SELECT ac_username FROM account;";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$ids = (array) null;
 while($row = $stmt->fetchColumn()){
    array_push($ids,$row);
}
 for ($i = 1; $i <= 20; $i++) {
    $sql2 = "UPDATE account SET ac_password=:pwd WHERE ac_username=:id;";
    $stmt2 = $pdo->prepare($sql2);
    $pwd = array_pop($pwds);
    // var_dump($pwd);
    $newpwd = password_hash($pwd,PASSWORD_DEFAULT);
    $id = array_pop($ids);
    $stmt2->execute(array(":pwd" => $newpwd,":id" => $id));
    echo $pwd."-----------".$newpwd."<br>";
}