<?php

session_start();
session_unset();
// setcookie("userid", "", time() - 60, "/", "", 0);//see here I set the time to -60 of the current time
session_destroy();
header('location:/building-managment/');
echo("<script type='text/javascript'>
            location.replace(\"/building-managment\");
            </script>");
// print_r($_SESSION);
exit();