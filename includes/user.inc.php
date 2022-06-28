<?php
include_once 'session.inc.php';
include_once "../php/conn.php";
include_once 'functions.inc.php';
include_once 'jdf.php';

if(isset($_POST['action']) && $_POST['action'] == 'save') {
    // if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // echo "enter function<br>";
    $userid = $_SESSION['username'];
    // $userid = '9712049433';
    $ufirtsname = $_POST['fname'];
    // var_dump($ufirtsname);
    $ulastname = $_POST['lname'];
    // var_dump($ulastname);
    $uage = $_POST['age'];
    $ugender = $_POST['gender'];
    $ucodemeli = $_POST['code-meli'];
    $uphone = $_POST['number'];
    $uapartment = $_POST['apartment-id'];
    $upwd = (empty($_POST['password']))? $_SESSION['nothashedPass']:$_POST['password'];
    $upwdrepeat = (empty($_POST['password-repeat']))? $_SESSION['nothashedPass']:$_POST['password-repeat'];
    if (passwordMatch($upwd, $upwdrepeat)) {
        header("location:../php/user-dashboard?error=passwordsdontmatch");
        exit();
    }
    if (!updateUserData($pdo, $userid, $ufirtsname, $ulastname, $uage, $ugender, $ucodemeli, $uapartment, $upwd)) {
        header("location:../php/user-dashboard.php?error=failedsubmit");
        exit();
    }
    if (is_uploaded_file($_FILES['upload-profile']['tmp_name'])) {
        
        // var_dump($_FILES['upload-profile']);
        $target_dir = "../data/users/" . $userid . "/";
        $file_input_name = 'upload-profile';
        $file_name = 'profile';
        $file_extension = 'jpg';
        $result = uploadfile($_FILES['upload-profile'],$target_dir,$file_name);
        if ($result == false) {
            # code...
            $message = 'متاسفانه ارسال فایل  عکس پروفایل با خطا مواجه شد!';
            echo '<script>alert("' . $message . '")</script>';
        }
    }
    if (is_uploaded_file($_FILES['upload-contract']['tmp_name'])) {
        // var_dump($_FILES['upload-contract']);
        $target_dir = "../data/users/" . $userid . "/";
        $file_input_name = 'upload-contract';
        $file_name = 'contract';
        $file_extension = 'jpg';
        $result = uploadfile($_FILES['upload-contract'],$target_dir,$file_name);
        if ($result == false) {
            # code...
            $message = 'متاسفانه ارسال فایل  عکس پروفایل با خطا مواجه شد!';
            echo '<script>alert("' . $message . '")</script>';
        }
    }
    header("location:../php/user-dashboard.php?user=successsubmit");
    exit();
    // echo ("<script type='text/javascript'>
    //         location.replace(\"/building-managment/php/user-dashboard.php?user=login\");
    //         </script>");
} 

if (isset($_POST['action']) && $_POST['action'] == 'logout') {
    header('location: ../includes/logout.inc.php');
}

elseif (isset($_POST['send'])) {

    $sender = $_SESSION['username'];
    $file_id = 0;
    $text = $_POST['text'];
    $recevier = $_POST['sendto'];
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
        header("location:../php/user-message.php?error=invalidtext");
        exit();
    }

    if (!isset($_POST['sendto'])) {
        // var_dump($GLOBALS);
        header("location:../php/user-message.php?error=emptyinput");
        exit();
    }

    if (isset($_FILES['upload-chat-file']) && $_FILES['upload-chat-file']['error'] === UPLOAD_ERR_OK) {
        $result  = uploadfile($_FILES['upload-chat-file'],'../data/messages/');
        if ($result['error'] === false) {
            header('location: ../php/user-message.php?error=failedupload');
            exit();
        }
        

    $sql = "INSERT INTO `file`(`username`,`name`,`extension`,`path`,`date`) VALUES(?,?,?,?,?);";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$sender,$result['name'],$result['extension'],$result['path'],$date2]);
    $result = $pdo->lastInsertId();
    
    $file_id = $result;
    
    }
    
    $sql = "INSERT INTO `message`(`sender`,`receiver`,`text`,`file`,`date`,`verify`) VALUES(?,?,?,?,?,?);";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$sender,$recevier,$text,$file_id,$date2,$verify]);

    echo ("<script type='text/javascript'>
            location.replace(\"/building-managment/php/user-message.php\");
            </script>");
}

// if(isset($_GET['logout-submit']) && $_GET['logout-submit'] == 'logout'){
//     // run logout code
//     require_once 'logout.inc.php';
// }


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
    header("location:../php/user-message.php");
    exit();
    // var_dump($messages);
}