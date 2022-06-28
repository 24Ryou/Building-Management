<?php
if (isset($_POST["submit"])) {
    // echo "it works";
    // echo '<br>';
    $username = $_POST["username"];
    $pwd = $_POST["password"];
    include_once "../php/conn.php";
    include_once "functions.inc.php";
    if (emptyInputLogin($username, $pwd) !== false) {
        header("location: ../php/login.php?error=emptyinput");
        exit();
    }
    if (invalidPhone($username) !== false) {
        header("location: ../php/login.php?error=invalidphone");
        exit();
    }
    if (invalidPassword($pwd) !== false) {
        header("location: ../php/login.php?error=invalidpasword");
        exit();
    }
    
    // echo "its here loginc line 25";
    loginUser($pdo, $username, $pwd);
} else {
    echo "<script>alert(didnt work)</script>didnt work:";
    header("location: ../php/login.php");
}
