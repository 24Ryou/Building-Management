<?php
include_once 'session.inc.php';
include_once '../php/conn.php';
include_once 'functions.inc.php';

$stmt = $pdo->prepare("SELECT * FROM `message` ORDER BY `message`.`date` DESC;");
$stmt->execute();
echo'

<div id="tab-alert" class="tab-alert">
<div class="alert-body">
    <li class="admin-alert__item admin-alert_menu d-flex">
        <div class="admin-alert_menu-checkbox d-flex">
        <label class="switch payment__input-checkbox">
            <input type="checkbox" name="readall" value="checked">
            <span class="slider"></span>
        </label>
        <h5>
            همه رو با عنوان خوانده شده علامت بزن!
        </h5>
        </div>
        <button class="button-nostyle admin-alert_menu-button noletterspace" type="submit" name="action" value="markread">اعمال خواندن</button>
    </li>
';
while($row = $stmt->fetch()) {
    if ($row['receiver'] == $_SESSION['username'] && $row['verify'] == '0') {
        # code...
        

        // echo '
        // <div class="alert__body d-flex">';
        if ($row['sender'] == '2') {
            $date = $row['date'];
            $YMD = getYMD($date);
            $HMS = getHMS($date);
            $HM = date("H:i", strtotime($HMS));
            $fulldate = $YMD . " " . $HMS;
            $ago = time_elapsed_string($fulldate);
            $text = $row['text'];
            $message;
            if ($row['file'] == 0) {
                # code...
                $message = $text;
            }
            else {
                $file_path = getFilePath($pdo, $row['file']);
                $path_parts = pathinfo($file_path);
                // $file_dirname = $path_parts['dirname'];
                $file_basename = $path_parts['basename'];
                $file_ext = $path_parts['extension'];
                $file_name = getFileName($pdo, $row['file']);
                $message = '<a class="chat-file-link" href="?file=messages/' . $file_basename . '"> فایل ( '.$file_ext.' ) </a><br>' . $row['text'];
            }
            # code...
            echo '
            <div class="alert d-flex">
                <div class="alert__header">
                    <div class="alert__date">
                        <span class="chat__day">'.$ago.'</span>
                        <span>،</span>
                        <span class="chat__time">'.$HM.'</span>
                    </div>
                </div>
                <div class="alert__body d-flex">
                <span class="material-icons-round alert__icon  alert__icon-warning">
                    warning
                </span>
                <span>
                <h4>هشدار</h4>
                    <span class="alert__text">
                    '.$message.'
                    </span>
                </span>
                </div>
                
                
                <input type="hidden" name="messageids[]" value="'.$row['id'].'">
                <div class="admin-alert__item-checkbox d-flex">
                <label class="switch payment__input-checkbox">
                    <input type="checkbox" name="read[]" value="'.$row['id'].'">
                    <span class="slider"></span>
                </label>
                <h5>
                خوانده شد
                </h5>
                </div>
            </div>
            ';
        }
        elseif ($row['sender'] == '1') {
            $date = $row['date'];
            $YMD = getYMD($date);
            $HMS = getHMS($date);
            $HM = date("H:i", strtotime($HMS));
            $fulldate = $YMD . " " . $HMS;
            $ago = time_elapsed_string($fulldate);
            $text = $row['text'];
            $message;
            if ($row['file'] == 0) {
                # code...
                $message = $text;
            }
            else {
                $file_path = getFilePath($pdo, $row['file']);
                $path_parts = pathinfo($file_path);
                // $file_dirname = $path_parts['dirname'];
                $file_basename = $path_parts['basename'];
                $file_ext = $path_parts['extension'];
                $file_name = getFileName($pdo, $row['file']);
                $message = '<a class="chat-file-link" href="?file=messages/' . $file_basename . '"> فایل ( '.$file_ext.' ) </a><br>' . $row['text'];
            }
            # code...
            echo '
            <div class="alert d-flex">
                <div class="alert__header">
                    <div class="alert__date">
                        <span class="chat__day">'.$ago.'</span>
                        <span>،</span>
                        <span class="chat__time">'.$HM.'</span>
                    </div>
                </div>
                <div class="alert__body d-flex">
                <span class="material-icons-round alert__icon alert__icon-setting">
                    settings
                </span>
                <span>
                <h4>سیستم</h4>
                    <span class="alert__text">
                    '.$message.'
                    </span>
                </span>
                </div>
                <input type="hidden" name="messageids[]" value="'.$row['id'].'">
                <div class="admin-alert__item-checkbox d-flex">
                <label class="switch payment__input-checkbox">
                    <input type="checkbox" name="read[]" value="'.$row['id'].'">
                    <span class="slider"></span>
                </label>
                <h5>
                خوانده شد
                </h5>
                </div>
            </div>
            ';
        }
        elseif($row['sender'] != $_SESSION['username'] && $row['sender'] != '0' && $row['sender'] != '1' && $row['sender'] != '2') {
            $profile = getProfile($pdo,$row['sender']);
            $lastname = getLastname($pdo,$row['sender']);
            $fisrtname = getFirstname($pdo,$row['sender']);
            $sql = "SELECT * FROM account WHERE ac_username=?";
            $stmt2 = $pdo->prepare($sql);
            $stmt2->execute([$row['sender']]);
            $data = $stmt2->fetch();
            $isAdmin = $data['ac_access'];
            $_SESSION['testprint'] = $isAdmin;
            $date = $row['date'];
            $YMD = getYMD($date);
            $HMS = getHMS($date);
            $HM = date("H:i", strtotime($HMS));
            $fulldate = $YMD . " " . $HMS;
            $ago = time_elapsed_string($fulldate);
            $text = $row['text'];
            $message;
            
            if ($isAdmin == '0') {
                if ($row['file'] == 0) {
                    # code...
                    $message = $text;
                }
                else {
                    $file_path = getFilePath($pdo, $row['file']);
                    $path_parts = pathinfo($file_path);
                    // $file_dirname = $path_parts['dirname'];
                    $file_basename = $path_parts['basename'];
                    $file_ext = $path_parts['extension'];
                    $file_name = getFileName($pdo, $row['file']);
                    $message = '<a class="chat-file-link" href="?file=messages/' . $file_basename . '"> فایل ( '.$file_ext.' ) </a><br>' . $row['text'];
                }
                echo '
                <div class="alert d-flex">
                    <div class="alert__header">
                        <div class="alert__date">
                            <span class="chat__day">'.$ago.'</span>
                            <span>،</span>
                            <span class="chat__time">'.$HM.'</span>
                        </div>
                    </div>
                    <div class="alert__body d-flex">
                    <div class="user-chat__photo">
                        <img src="' . $profile . '">
                    </div>
                    <span>
                    <h4 class="alert__name clr-danger">'.$fisrtname." ".$lastname.'</h4>
                        <span class="alert__text">
                        '.$message.'
                        </span>
                    </span>
                    </div>
                    <input type="hidden" name="messageids[]" value="'.$row['id'].'">
                    <div class="admin-alert__item-checkbox d-flex">
                    <label class="switch payment__input-checkbox">
                        <input type="checkbox" name="read[]" value="'.$row['id'].'">
                        <span class="slider"></span>
                    </label>
                    <h5>
                    خوانده شد
                    </h5>
                    </div>
                </div>
                ';
            }
            else {
                if ($row['file'] == 0) {
                    # code...
                    $message = $text;
                }
                else {
                    $file_path = getFilePath($pdo, $row['file']);
                    $path_parts = pathinfo($file_path);
                    // $file_dirname = $path_parts['dirname'];
                    $file_basename = $path_parts['basename'];
                    $file_ext = $path_parts['extension'];
                    $file_name = getFileName($pdo, $row['file']);
                    $message = '<a class="chat-file-link" href="?file=messages/' . $file_basename . '"> فایل ( '.$file_ext.' ) </a><br>' . $row['text'];
                }
                echo '
                <div class="alert d-flex">
                    <div class="alert__header">
                        <div class="alert__date">
                            <span class="chat__day">'.$ago.'</span>
                            <span>،</span>
                            <span class="chat__time">'.$HM.'</span>
                        </div>
                    </div>
                    <div class="alert__body d-flex">
                    <span class="material-icons-round alert__icon  alert__icon-admin">
                        account_circle
                    </span>
                    <span>
                    <h4 class="alert__name">ادمین</h4>
                        <span class="alert__text">
                        '.$message.'
                        </span>
                    </span>
                    </div>
                    <input type="hidden" name="messageids[]" value="'.$row['id'].'">
                    <div class="admin-alert__item-checkbox d-flex">
                    <label class="switch payment__input-checkbox">
                        <input type="checkbox" name="read[]" value="'.$row['id'].'">
                        <span class="slider"></span>
                    </label>
                    <h5>
                    خوانده شد
                    </h5>
                    </div>
                </div>
                ';
            }
        }
    }
}
echo "

</div>
";
?>