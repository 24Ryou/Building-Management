<?php
if (isset($_POST["submit"])) {
    // echo "it works";
    $name = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $pwd = $_POST["password"];
    $pwdRepeat = $_POST["passwordrepeat"];
    $phone = $_POST["phone"];
    require_once "../php/conn.php";
    require_once "functions.inc.php";
    if (emptyInputSignup($name,$lastname,$pwd,$pwdRepeat,$phone) !== false) {
        header("location: ../php/signup.php?error=emptyinput");
        exit();
    }
    if (invalidName($name) !== false) {
        header("location: ../php/signup.php?error=invalidfirst-name");
        exit();
    }
    if (invalidLastname($lastname) !== false) {
        header("location: ../php/signup.php?error=invalidlast-name");
        exit();
    }
    if (invalidPassword($pwd) !== false) {
        header("location: ../php/signup.php?error=invalidpasword");
        exit();
    }
    if (passwordMatch($pwd,$pwdRepeat) !== false) {
        header("location: ../php/signup.php?error=passwordsdontmatch");
        exit();
    }
    if (invalidPhone($phone) !== false) {
        header("location: ../php/signup.php?error=invalidphone");
        exit();
    }
    if (phoneExists($pdo,$phone) !== false) {
        header("location: ../php/signup.php?error=phonetaken");
        exit();
    }
createUser($pdo, $name,$lastname,$pwd,$phone);
}
else {
    header("location: ../php/signup.php");
}