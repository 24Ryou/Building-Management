<?php
include_once 'session.inc.php';
include_once '../php/conn.php';
include_once 'functions.inc.php';

$stmt = $pdo->prepare("SELECT * FROM `message` ORDER BY `message`.`date` DESC;");
$stmt->execute();
$nomessage = 'پیامی در سیستم جهت نمایش وجود نداشت!';
$flag = 1;

while($row = $stmt->fetch()) {
    if (($row['receiver'] == $_SESSION['username'] || $row['receiver'] == '1') && $row['verify']=='0') {
        $flag=0;
        // echo '
        // <div class="alert__body d-flex">';
        if ($row['sender'] != $_SESSION['username'] && $row['sender'] != '2' && $row['sender'] != '1' && $row['sender'] != '0') {
            $profile = getProfile($pdo,$row['sender']);
            $lastname = getLastname($pdo,$row['sender']);
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
            <li class="admin-alert__item d-column">
                <div class="admin-alert__item-header d-flex">
                    <div class="admin-alert__item-header-day">' .$ago. '</div>
                    ،
                    <div class="admin-alert__item-header-time">' .$HM. '</div>
                </div>
                <div class="admin-alert__item-body d-flex admin-alert__item-tenant">
                        
                    <div class="admin-chat__photo">
                    <img src="' . $profile . '">
                    </div>
                    <div class="admin-alert__item-body-text d-column">
                        <h4 class="clr-danger">'.$lastname.'</h4>
                        <p>
                        '.$message.'
                        </p>
                    </div>
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
            </li>
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
            <li class="admin-alert__item d-column">
            <div class="admin-alert__item-header d-flex">
                <div class="admin-alert__item-header-day">'.$ago.'</div>
                <div class="admin-alert__item-header-time">'.$HM.'</div>
            </div>
            <div class="admin-alert__item-body d-flex admin-alert__item-setting">
                <span class="material-icons-round">
                    settings
                </span>
                <div class="admin-alert__item-body-text d-column">
                    <h4>سیستم</h4>
                    <p>
                    '.$message.'
                    </p>
                </div>
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
            </li>
            ';
        }
        elseif ($row['sender'] == '0') {
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
            <li class="admin-alert__item d-column">
                <div class="admin-alert__item-header d-flex">
                    <div class="admin-alert__item-header-day">'.$ago.'</div>
                    <div class="admin-alert__item-header-time">'.$HM.'</div>
                </div>
                <div class="admin-alert__item-body d-flex admin-alert__item-warning">
                    <span class="material-icons-round">
                        warning
                    </span>
                    <div class="admin-alert__item-body-text d-column">
                        <h4>هشدار</h4>
                        <p>
                        '.$message.'
                        </p>
                    </div>
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
            </li>
            ';
        }
    }
}
if ($flag == 1) {
        $message = 'پیامی ندارید!';
    echo '<li class="admin-alert__item d-column ">
            <p class="clr-dark">
            '.$nomessage.'
            </p>
        </li>';
}
?>