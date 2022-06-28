<?php

require_once "../php/conn.php";
require_once 'functions.inc.php';

getUserData($pdo, $_SESSION['username']);

