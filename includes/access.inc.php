<?php
session_start();
if (isset($_SESSION["access"]) == 0) {
    header("location:../index.php");
    exit(); // prevent further execution, should there be more code that follows;
}