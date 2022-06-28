<?php
require_once '../php/conn.php';
require_once 'jdf.php';

$sql = "SELECT * FROM `message` WHERE `receiver`= ? ORDER BY `message`.`date` DESC;";
$stmt = $pdo->prepare($sql);
$stmt->execute(['0']);
while ($chat = $stmt->fetch()) {
    if ($chat['sender'] != '0' && $chat['sender'] != '1' && $chat['sender'] != '2') {
        # code...
        // updateVerify($pdo,$chat['receiver']);
        $date = $chat['date'];
    $YMD = getYMD($date);
    $HMS = getHMS($date);
    $HM = date("H:i", strtotime($HMS));
    $fulldate = $YMD . " " . $HMS;
    $lastname = getLastname($pdo, $chat['sender']);
    $ago = time_elapsed_string($fulldate);
    $verifyclass = '';
    if ($chat['sender'] == $_SESSION['username']) {
        if ($chat['file'] == 0) {
            $message = $chat['text'];
        } else {
            $file_path = getFilePath($pdo, $chat['file']);
            $path_parts = pathinfo($file_path);
            // $file_dirname = $path_parts['dirname'];
            $file_basename = $path_parts['basename'];
            $file_ext = $path_parts['extension'];
            $file_name = getFileName($pdo, $chat['file']);
            $message = '<a class="chat-file-link" href="?file=messages/' . $file_basename . '"> فایل ( '.$file_ext.' ) </a><br>' . $chat['text'];
        }
        echo ' <li class="admin-chat__item d-column admin-chat-my">
                    <div class="admin-chat__header d-flex">
                        <div class="admin-chat__date d-flex">
                            <span class="admin-chat__day">' . $ago . '</span>
                            <span>،</span>
                            <span class="admin-chat__time">' . $HM . '</span>
                        </div>
                    </div>
                    <div class="admin-chat__body">
                    ' . $message . '
                    </div>
                </li>'
            ;
    } else {
        if ($chat['file'] == 0) {
            $message = $chat['text'];
        } else {
            $file_path = getFilePath($pdo, $chat['file']);
            $file_name = getFileName($pdo, $chat['file']);
            $message = '<a class="chat-file-link" href="' . $file_path . '">' . $file_name . '</a><br>' . $chat['text'];
        }
        $profilePath = getProfile($pdo,$chat['sender']);
        if ($chat['verify']==0) {
            $verifyclass = '';
        }
        echo '<li class="admin-chat__item d-column admin-chat-other">
                <div class="admin-chat__header d-flex">
                    <div class="admin-chat__photo">
                        <img src="' . $profilePath . '">
                    </div>
                    <span class="admin-chat__name d-flex">' . $lastname . '</span>
                    <div class="admin-chat__date d-flex">
                        <span class="admin-chat__day">' . $ago . '</span>
                        <span>،</span>
                        <span class="admin-chat__time">' . $HM . '</span>
                    </div>
                </div>
                <div class="admin-chat__body '.$verifyclass.'">
                ' . $message . '
                </div>
            </li>
            ';
    }
    }
}
$chat_day = '';
?>
