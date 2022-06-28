<?php

include_once 'session.inc.php';
include_once "../php/conn.php";
include_once 'functions.inc.php';
include_once 'jdf.php';


if (isset($_GET['tab']) && $_GET['tab'] == 'apartment') {
    $_SESSION['tabSort'] = 'ap_number';
    $_SESSION['ascdesc'] = 'ASC';
    $_SESSION['tab'] = 'apartment';
    if (isset($_GET['sort']) && $_GET['sort'] == 'name') {
        $_SESSION['sort'] = 'name';
        $_SESSION['tabSort'] = 'ac_firstname';
        $_SESSION['ascdesc'] = ($_GET['mode'] === 'ASC') ? 'DESC' : 'ASC';
    }
    if (isset($_GET['sort']) && $_GET['sort'] == 'lastname') {
        $_SESSION['sort'] = 'lastname';
        $_SESSION['tabSort'] = 'ac_lastname';
        $_SESSION['ascdesc'] = ($_GET['mode'] === 'ASC') ? 'DESC' : 'ASC';
    }
    if (isset($_GET['sort']) && $_GET['sort'] == 'apartment') {
        $_SESSION['sort'] = 'apartment';
        $_SESSION['tabSort'] = 'ap_number';
        $_SESSION['ascdesc'] = ($_GET['mode'] === 'ASC') ? 'DESC' : 'ASC';
    }
    if (isset($_GET['sort']) && $_GET['sort'] == 'people') {
        $_SESSION['sort'] = 'people';
        $_SESSION['tabSort'] = 'ap_people';
        $_SESSION['ascdesc'] = ($_GET['mode'] === 'ASC') ? 'DESC' : 'ASC';
    }
    if (isset($_GET['sort']) && $_GET['sort'] == 'parking') {
        $_SESSION['sort'] = 'parking';
        $_SESSION['tabSort'] = 'ap_parkingid';
        $_SESSION['ascdesc'] = ($_GET['mode'] === 'ASC') ? 'DESC' : 'ASC';
    }
    if (isset($_GET['sort']) && $_GET['sort'] == 'waterid') {
        $_SESSION['sort'] = 'waterid';
        $_SESSION['tabSort'] = 'ap_waterid';
        $_SESSION['ascdesc'] = ($_GET['mode'] === 'ASC') ? 'DESC' : 'ASC';
    }
    if (isset($_GET['sort']) && $_GET['sort'] == 'powerid') {
        $_SESSION['sort'] = 'powerid';
        $_SESSION['tabSort'] = 'ap_powerid';
        $_SESSION['ascdesc'] = ($_GET['mode'] === 'ASC') ? 'DESC' : 'ASC';
    }
    if (isset($_GET['sort']) && $_GET['sort'] == 'gasid') {
        $_SESSION['sort'] = 'gasid';
        $_SESSION['tabSort'] = 'ap_gasid';
        $_SESSION['ascdesc'] = ($_GET['mode'] === 'ASC') ? 'DESC' : 'ASC';
    }
}
if (isset($_GET['tab']) && $_GET['tab'] == 'account') {
    $_SESSION['tabSort'] = 'ac_lastname';
    $_SESSION['ascdesc'] = 'ASC';
    $_SESSION['tab'] = 'account';
    if (isset($_GET['sort']) && $_GET['sort'] == 'id') {
        $_SESSION['sort'] = 'id';
        $_SESSION['tabSort'] = 'ac_username';
        $_SESSION['ascdesc'] = ($_GET['mode'] === 'ASC') ? 'DESC' : 'ASC';
    }
    if (isset($_GET['sort']) && $_GET['sort'] == 'name') {
        $_SESSION['sort'] = 'name';
        $_SESSION['tabSort'] = 'ac_firstname';
        $_SESSION['ascdesc'] = ($_GET['mode'] === 'ASC') ? 'DESC' : 'ASC';
    }
    if (isset($_GET['sort']) && $_GET['sort'] == 'lastname') {
        $_SESSION['sort'] = 'lastname';
        $_SESSION['tabSort'] = 'ac_lastname';
        $_SESSION['ascdesc'] = ($_GET['mode'] === 'ASC') ? 'DESC' : 'ASC';
    }
    if (isset($_GET['sort']) && $_GET['sort'] == 'apartment') {
        $_SESSION['sort'] = 'apartment';
        $_SESSION['tabSort'] = 'ac_apartment';
        $_SESSION['ascdesc'] = ($_GET['mode'] === 'ASC') ? 'DESC' : 'ASC';
    }
    if (isset($_GET['sort']) && $_GET['sort'] == 'rent') {
        $_SESSION['sort'] = 'rent';
        $_SESSION['tabSort'] = 'ac_rent';
        $_SESSION['ascdesc'] = ($_GET['mode'] === 'ASC') ? 'DESC' : 'ASC';
    }
    if (isset($_GET['sort']) && $_GET['sort'] == 'charge') {
        $_SESSION['sort'] = 'charge';
        $_SESSION['tabSort'] = 'ac_charge';
        $_SESSION['ascdesc'] = ($_GET['mode'] === 'ASC') ? 'DESC' : 'ASC';
    }
    if (isset($_GET['sort']) && $_GET['sort'] == 'debit') {
        $_SESSION['sort'] = 'debit';
        $_SESSION['tabSort'] = 'ac_debit';
        $_SESSION['ascdesc'] = ($_GET['mode'] === 'ASC') ? 'DESC' : 'ASC';
    }
    if (isset($_GET['sort']) && $_GET['sort'] == 'credit') {
        $_SESSION['sort'] = 'credit';
        $_SESSION['tabSort'] = 'ac_credit';
        $_SESSION['ascdesc'] = ($_GET['mode'] === 'ASC') ? 'DESC' : 'ASC';
    }
}
if (isset($_GET['tab']) && $_GET['tab'] == 'report') {
    $_SESSION['tab'] = 'report';
    $_SESSION['tabSort'] = 'date';
    $_SESSION['ascdesc'] = 'DESC';
    if (isset($_GET['sort']) && $_GET['sort'] == 'name') {
        $_SESSION['sort'] = 'name';
        $_SESSION['tabSort'] = 'ac_firstname';
        $_SESSION['ascdesc'] = ($_GET['mode'] === 'ASC') ? 'DESC' : 'ASC';
    }
    if (isset($_GET['sort']) && $_GET['sort'] == 'lastname') {
        $_SESSION['sort'] = 'lastname';
        $_SESSION['tabSort'] = 'ac_lastname';
        $_SESSION['ascdesc'] = ($_GET['mode'] === 'ASC') ? 'DESC' : 'ASC';
    }
    if (isset($_GET['sort']) && $_GET['sort'] == 'price') {
        $_SESSION['sort'] = 'price';
        $_SESSION['tabSort'] = 'price';
        $_SESSION['ascdesc'] = ($_GET['mode'] === 'ASC') ? 'DESC' : 'ASC';
    }
    if (isset($_GET['sort']) && $_GET['sort'] == 'info') {
        $_SESSION['sort'] = 'info';
        $_SESSION['tabSort'] = 'info';
        $_SESSION['ascdesc'] = ($_GET['mode'] === 'ASC') ? 'DESC' : 'ASC';
    }
    if (isset($_GET['sort']) && $_GET['sort'] == 'order') {
        $_SESSION['sort'] = 'order';
        $_SESSION['tabSort'] = 'order_verify';
        $_SESSION['ascdesc'] = ($_GET['mode'] === 'ASC') ? 'DESC' : 'ASC';
    }
    if (isset($_GET['sort']) && $_GET['sort'] == 'date') {
        $_SESSION['sort'] = 'date';
        $_SESSION['tabSort'] = 'date';
        $_SESSION['ascdesc'] = ($_GET['mode'] === 'ASC') ? 'DESC' : 'ASC';
    }
}
if (isset($_GET['tab']) && $_GET['tab'] == 'add') {
    $_SESSION['tab'] = 'add';
}
if (isset($_GET['tab']) && $_GET['tab'] == 'profile') {
    $_SESSION['tab'] = 'profile';
}
if (isset($_GET['search']) && $_GET['search']=="") {
    $_SESSION['search'] = "";
}
if (isset($_GET['select']) && $_GET['select']=="teneat") {
    $_SESSION['selectStatus'] = "";
}