<?php


include_once 'session.inc.php';
include_once 'functions.inc.php';
include_once '../php/conn.php';


$_SESSION['pay-info'] = "";
$_SESSION['pay-info'] = ($_SESSION['pay-info'] == "") ? "":$_SESSION['pay-info'];
$_SESSION['total-cost'] = "";
$_SESSION['total-cost'] = ($_SESSION['total-cost'] == "") ? 0:$_SESSION['total-cost'];