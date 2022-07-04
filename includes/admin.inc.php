<?php 

include_once 'session.inc.php';
include_once "../php/conn.php";
include_once 'functions.inc.php';
include_once 'jdf.php';

// var_dump($_POST['action']);

if(isset($_POST['action']) && $_POST['action'] == 'save') {
    if ($_SESSION['tab'] == 'profile') {
        $userid = $_SESSION['username'];
        $ufirtsname = $_POST['pname'];
        $ulastname = $_POST['plastname'];
        $uage = $_POST['age'];
        $ugender = $_POST['gender'];
        $ucodemeli = $_POST['pcodemelli'];
        $uphone = $_POST['pphone'];
        $uapartment = $_POST['apartment-id'];
        $upwd = (empty($_POST['password']))? $_SESSION['nothashedPass']:$_POST['password'];
        $upwdrepeat = (empty($_POST['password-repeat']))? $_SESSION['nothashedPass']:$_POST['password-repeat'];
        if (passwordMatch($upwd, $upwdrepeat)) {
            header("location:../php/admin-dashboard?tab=profile&error=passwordsdontmatch");
            exit();
        }
        if (!updateUserData($pdo, $userid, $ufirtsname, $ulastname, $uage, $ugender, $ucodemeli, $uapartment, $upwd)) {
            header("location:../php/admin-dashboard.php?tab=profile&error=failedsubmit");
            exit();
        }
        if (isset($_FILES['puprofile']) && $_FILES['puprofile']['error'] === UPLOAD_ERR_OK) {
            // var_dump($_FILES['puprofile']);
            $target_dir = "../data/admin/" . $userid . "/";
            $file_input_name = 'puprofile';
            $file_name = 'profile';
            $file_extension = 'jpg';
            
            $result = uploadfile($_FILES['puprofile'],$target_dir,$file_name);
            if ($result == false) {
                # code...
                $message = 'متاسفانه ارسال فایل  عکس پروفایل با خطا مواجه شد!';
                echo '<script>alert("' . $message . '")</script>';
            }
        }
        header('location:../php/admin-dashboard.php?tab=profile&admin=successsubmit');
        exit();
    }
    elseif ($_SESSION['tab'] == 'add') {
        if (empty($_POST['name']) && empty($_POST['rent']) && empty($_POST['codemelli']) && empty($_POST['lastname']) && empty($_POST['phone']) &&  empty($_POST['charge']) && !empty($_POST['add-apartment'])) {
            $apnumber = $pdo->query("SELECT COUNT(*) FROM apartment")->fetchColumn();
            for ($i=1; $i <= (int)$_POST['add-apartment'] ; $i++) { 
                $sum = $apnumber+$i;
                $pdo->prepare("INSERT INTO apartment(ap_number) VALUES ($sum);")->execute();
            }
            header('location:../php/admin-dashboard.php?tab=add&admin=successcreateapartment');
            exit();
        }
        if (empty($_POST['name']) && empty($_POST['rent']) && empty($_POST['codemelli']) && empty($_POST['lastname']) && empty($_POST['phone']) &&  empty($_POST['charge']) && empty($_POST['add-apartment'])){
            
            header('location:../php/admin-dashboard.php?tab=add&admin=emptyAddall');
            exit();
        }
        if (empty($_POST['name']) || empty($_POST['rent']) || empty($_POST['codemelli']) || empty($_POST['lastname']) || empty($_POST['phone']) ||  empty($_POST['charge'])) {
            header('location:../php/admin-dashboard.php?tab=add&admin=emptystar');
            exit();
        }
        else{
            if (!empty($_POST['add-apartment'])) {
                $apnumber = $pdo->query("SELECT COUNT(*) FROM apartment")->fetchColumn();
            for ($i=1; $i <= (int)$_POST['add-apartment'] ; $i++) { 
                $sum = $apnumber+$i;
                $pdo->prepare("INSERT INTO apartment(ap_number) VALUES ($sum);")->execute();
            }
            }
            $name = $_POST['name'];
            $apartment = $_POST['apartment'];
            $codemelli = $_POST['codemelli'];
            $lastname = $_POST['lastname'];
            $rent = $_POST['rent'];
            $phone = $_POST['phone'];
            $charge = $_POST['charge'];
            $status = $_POST['status'];
            $sql = "INSERT INTO account(ac_username,ac_firstname,ac_lastname,ac_codemelli,ac_apartment,ac_rent,ac_charge) VALUES(?,?,?,?,?,?,?);";
            $stmt = $pdo->prepare($sql);
            
            if ($stmt->execute([$phone,$name,$lastname,$codemelli,$apartment,$rent,$charge])) {
                header('location:../php/admin-dashboard.php?tab=add&admin=successsubmit');
                exit();
            }
            header('location:../php/admin-dashboard.php?tab=add&admin=failedsubmit');
            exit();
        }
    }
    else {
        $account = $_SESSION['userIDs'];
        
        if ($_SESSION['tab'] == 'apartment') {
            $ap_firstname = ($_POST['ap_firstname'] == "") ? "" : $_POST['ap_firstname'];
            $ap_lastname = ($_POST['ap_lastname'] == "") ? "" : $_POST['ap_lastname'];
            $ap_apartment = ($_POST['ap_apartment'] == "") ? "" : $_POST['ap_apartment'];
            $people = ($_POST['ap_people'] == "") ? "" : $_POST['ap_people'];
            $waterid = ($_POST['ap_waterid'] == "") ? "" : $_POST['ap_waterid'];
            $powerid = ($_POST['ap_powerid'] == "") ? "" : $_POST['ap_powerid'];
            $gasid = ($_POST['ap_gasid'] == "") ? "" : $_POST['ap_gasid'];
            $lenap = (count($ap_apartment) != 0) ? count($ap_apartment) : 0;
            for ($i=0; $i < $lenap; $i++) {
                $sql = "UPDATE `apartment` SET ap_people=:people , ap_waterid=:waterid , ap_powerid=:powerid , 
                ap_gasid=:gasid WHERE ap_number=:apnumber;";
                $stmt = $pdo->prepare($sql);
                // $stmt->execute([$people[$id] ,$waterid[$id] ,$powerid[$id] ,$gasid[$id] , $newApartment]);
                $stmt->execute(
                    array(':people' => $people[$i],':waterid' => $waterid[$i],':powerid' => $powerid[$i], 
                    ':gasid' => $gasid[$i],':apnumber' => $account[0]));
            }
        }
        if ($_SESSION['tab'] == 'account') {
            $ac_status = $_POST['ac_status'];
            $account = $_POST['ac_username'];
            $ac_firstname = ($_POST['ac_firstname'] == "") ? "" : $_POST['ac_firstname'];
            $ac_lastname = ($_POST['ac_lastname'] == "") ? "" : $_POST['ac_lastname'];
            $ac_apartment = ($_POST['ac_apartment'] == "") ? "" : $_POST['ac_apartment'];$rent = ($_POST['ac_rent'] == "") ? "" : $_POST['ac_rent'];
            $charge = ($_POST['ac_charge'] == "") ? "" : $_POST['ac_charge'];
            $debit = ($_POST['ac_debit'] == "") ? "" : $_POST['ac_debit'];
            $credit = ($_POST['ac_credit'] == "") ? "" : $_POST['ac_credit'];
            $lenac = (count($ac_apartment) != 0) ? count($ac_apartment) : 0;
            for ($i=0; $i < $lenac; $i++) {
                $sql = "UPDATE `account` SET ac_status=:stat, ac_firstname=:firstname , ac_lastname=:lastname , ac_apartment=:apartment , 
                ac_rent=:rent , ac_charge=:charge , ac_debit=:debit , ac_credit=:credit  WHERE ac_username=:username;";
                // $sql = "UPDATE `account` SET ac_firstname='$ac_firstname[$i]' , ac_lastname='$ac_lastname[$i]' ,
                // ac_apartment='$ac_apartment[$i]' , ac_rent='$rent[$i]' , ac_charge='$charge[$i]' , 
                // ac_debit='$debit[$i]' , ac_credit='$credit[$i]'  WHERE ac_username='$account[$i]'";
                $stmt = $pdo->prepare($sql);
                // $stmt->execute([$ac_firstname[$i] , $ac_lastname[$i] , $ac_apartment[$i] , $rent[$i] , $charge[$i] , $debit[$i] , $credit[$i] , $account[$i]]);
                $stmt->execute(
                array(':stat'=>$ac_status[$i],':firstname' => $ac_firstname[$i],':lastname' => $ac_lastname[$i],
                ':apartment' => $ac_apartment[$i], ':rent' => $rent[$i],':charge' => $charge[$i],
                ':debit' => $debit[$i],':credit' => $credit[$i], ':username' => $account[$i]));
                $w = $stmt->execute();
            }
        }
        if ($_SESSION['tab'] == 'report') {
            $r_firstname = ($_POST['r_firstname'] == "") ? "" : $_POST['r_firstname'];
            $r_firstname = ($_POST['r_lastname'] == "") ? "" : $_POST['r_lastname'];
            $price = ($_POST['r_price'] == "") ? "" : $_POST['r_price'];
            $info = ($_POST['r_info'] == "") ? "" : $_POST['r_info'];
            $verify = ($_POST['r_verify'] == "") ? "" : $_POST['r_verify'];
            $date = ($_POST['r_date'] == "") ? "" : $_POST['r_date'];
            $lenr = (count($r_firstname) != 0) ? count($r_firstname) : 0;
            for ($i=0; $i < $lenr; $i++) { 
                $sql = "UPDATE `tran` SET price=:price , info=:info , `date`=:datee WHERE id=:id;";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(
                    array(':price' => $price[$i],':info' => $info[$i],':datee' => $date[$i], ':id' => $account[$i]));
            }
        }
        // check-box for delete not use here!!
        $delete = (isset($_POST['delete'])) ? $_POST['delete'] : "";
            # code...
        header("location:../php/admin-dashboard.php?admin=successsubmit");
        exit();
    }
}

elseif(isset($_POST['action']) && $_POST['action'] == 'delete') {

    if ( $_SESSION['tab'] == "apartment") {
        
        $delete = (isset($_POST['delete'])) ? $_POST['delete'] : "";
        if ($delete == "") {
            # code...
            header("location:../php/admin-dashboard.php?admin=deletenotselect");
            exit();
        }
        else {
            foreach($delete as $key => $value) {
                // $newApartment = $pdo->query('SELECT `ac_apartment` FROM `account` WHERE ac_username='.$value.';')->fetchAll(PDO::FETCH_COLUMN);
                // $pdo->prepare('DELETE FROM `account` WHERE ac_username=?')->execute([$value]);
                $pdo->prepare('DELETE FROM `apartment` WHERE ap_number=?')->execute([$value]);
            }
            header("location:../php/admin-dashboard.php?admin=successdelete");
            exit();
        }
    }
    if ( $_SESSION['tab'] == "account") {
        
        $delete = (isset($_POST['delete'])) ? $_POST['delete'] : "";
        if ($delete == "") {
            # code...
            header("location:../php/admin-dashboard.php?admin=deletenotselect");
            exit();
        }
        else {
            foreach($delete as $key => $value) {
                // $newApartment = $pdo->query('SELECT `ac_apartment` FROM `account` WHERE ac_username='.$value.';')->fetchAll(PDO::FETCH_COLUMN);
                $pdo->prepare('DELETE FROM `account` WHERE ac_username=?')->execute([$value]);
                // $pdo->prepare('DELETE FROM `apartment` WHERE ap_number=?')->execute([$newApartment[0]]);
            }
            header("location:../php/admin-dashboard.php?admin=successdelete");
            exit();
        }
    }
    if ( $_SESSION['tab'] == "report") {
        
        $delete = (isset($_POST['delete'])) ? $_POST['delete'] : "";
        if ($delete == "") {
            # code...
            header("location:../php/admin-dashboard.php?admin=deletenotselect");
            exit();
        }
        else {
            foreach($delete as $key => $value) {
                // $newApartment = $pdo->query('SELECT `ac_apartment` FROM `account` WHERE ac_username='.$value.';')->fetchAll(PDO::FETCH_COLUMN);
                $pdo->prepare('DELETE FROM `tran` WHERE orders=?')->execute([$value]);
                $pdo->prepare('DELETE FROM `orders` WHERE order_id=?')->execute([$value]);
            }
            header("location:../php/admin-dashboard.php?admin=successdelete");
            exit();
        }
    }
}

elseif(isset($_POST['action']) && $_POST['action'] == 'backup') {
    backup_tables($pdo,"account,apartment,message,tran,file,orders" , 'BM-db');
    // header("location:../php/admin-dashboard.php?admin=backupsuccess");
    // exit();
}

elseif(isset($_POST['action']) && $_POST['action'] == 'search') {
    $_SESSION['search'] = $_POST['searchData'];
    $tab = $_SESSION['tab'];
    $sort = $_SESSION['tabSort'];
    $ascdesc = $_SESSION['ascdesc'];
    // $query = parse_url($url, PHP_URL_QUERY);

    // // Returns a string if the URL has parameters or NULL if not
    // if ($query) {
    //     $url .= '&sea=1';
    // } else {
    //     $url .= '?category=1';
// }
    $url =  $_POST['value'];
    header("location:../php/admin-dashboard.php?tab=$tab");
    exit();
}

elseif (isset($_POST['action']) && $_POST['action'] == 'send') {

    $sender = $_SESSION['username'];
    $file_id = 0;
    $text = $_POST['text'];
    $recevier = $_POST['sendto'];
    $selectlist = $_POST['selectlist'];
    $verify = '0';
    $date = jdate('Y-m-d H:i:s',time(),'','Asia/Tehran','en');
    // var_dump($date);
    $date = strtotime($date);
    $date2 = date('Y-m-d H:i:s',$date);
    // $_SESSION['start_date'] = $_POST['start-date'];
    // $_SESSION['end_date'] = $_POST['end-date'];
    // var_dump($date);
    // var_dump($date2)

    if (preg_match('/^[^\x{600}-\x{6FF}]+$/u', $text)) {
        # code...
        header("location:../php/admin-message.php?error=invalidtext");
        exit();
    }

    if (!isset($_POST['sendto'])) {
        // var_dump($GLOBALS);
        header("location:../php/admin-message.php?error=emptyinput");
        exit();
    }

    if (isset($_FILES['upload-chat-file']) && $_FILES['upload-chat-file']['error'] === UPLOAD_ERR_OK) {
        $result  = uploadfile($_FILES['upload-chat-file'],'../data/messages/');
        if ($result['error'] === false) {
            header('location: ../php/admin-message.php?error=failedupload');
            exit();
        }
        
    

            
        $sql = "INSERT INTO `file`(`username`,`name`,`extension`,`path`,`date`) VALUES(?,?,?,?,?);";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$sender,$result['name'],$result['extension'],$result['path'],$date2]);
        $result = $pdo->lastInsertId();
        
        $file_id = $result;
    
    }
    
    if ($recevier == 'tenant') {
        $sql = "INSERT INTO `message`(`sender`,`receiver`,`text`,`file`,`date`,`verify`) VALUES(?,?,?,?,?,?);";
        $stmt = $pdo->prepare($sql);
        foreach($selectlist as $a) {
            $st = $pdo->prepare("SELECT * FROM account WHERE ac_apartment = ?;");
            $st->execute([$a]);
            $account = $st->fetch();
            $stmt->execute([$sender,$account['ac_username'],$text,$file_id,$date2,$verify]);
        }
    }
    else {
        $sql = "INSERT INTO `message`(`sender`,`receiver`,`text`,`file`,`date`,`verify`) VALUES(?,?,?,?,?,?);";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$sender,$recevier,$text,$file_id,$date2,$verify]);
    }

    echo ("<script type='text/javascript'>
            location.replace(\"/building-managment/php/admin-message.php\");
            </script>");
}

elseif (isset($_POST['action']) && $_POST['action'] == 'markread') {
    $checkall = (empty($_POST['readall']))? "0" : $_POST['readall'];
    $checkboxs = (empty($_POST['read']))? "0" : $_POST['read'];
    $messageid = $_POST['messageids'];
    if ($checkall == 'checked') {
        foreach($messageid as $id) {
            $pdo->prepare("UPDATE `message` SET verify=:checked WHERE id=:messageid;")->execute(array(':checked'=>'1' , ':messageid'=>$id));
        }
    }
    if ($checkboxs != '0') {
        for ($i=0; $i < count($checkboxs); $i++) { 
            if (!empty($checkboxs[$i])) {
                $pdo->prepare("UPDATE `message` SET verify=:checked WHERE id=:messageid;")->execute(array(':checked'=>'1' , ':messageid'=>$checkboxs[$i]));
                var_dump($checkboxs[$i]);
            }
        }
    }
    header("location:../php/admin-message.php");
    exit();
    // var_dump($messages);
}