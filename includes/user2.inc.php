<?php

include_once 'session.inc.php';
include_once "../php/conn.php";
include_once 'functions.inc.php';
include_once 'jdf.php';

if (isset($_GET['tab']) && $_GET['tab'] == 'chat') {
    $_SESSION['tab'] = 'chat';
}
if (isset($_GET['tab']) && $_GET['tab'] == 'alert') {
    $_SESSION['tab'] = 'alert';
}