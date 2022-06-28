<?php
require_once '../php/conn.php';
require_once 'jdf.php';

$sql = "SELECT * FROM `message` WHERE `receiver`= ? ORDER BY `message`.`date` DESC;";
$stmt = $pdo->prepare($sql);
$stmt->execute(['0']);
echo '
<div id="tab-conv" class="tab-conv">
<ul class="chat">
';
while ($chat = $stmt->fetch()) {
    $stmt2 = $pdo->prepare("SELECT * FROM `account` WHERE ac_username=?");
    $stmt2->execute([$chat['sender']]);
    $personData = $stmt2->fetch();
    if ($chat['sender'] != '0' && $chat['sender'] != '1' && $chat['sender'] != '2') {
        # code...
        // updateVerify($pdo,$chat['receiver']);
        $date = $chat['date'];
        $YMD = getYMD($date);
        $HMS = getHMS($date);
        $HM = date("H:i", strtotime($HMS));
        $fulldate = $YMD . " " . $HMS;
        if ($personData['ac_access'] == '1') {
            $lastname2 = getLastname($pdo, $chat['sender']);
            $lastname = '<span class="chat__name d-flex clr-danger">'.$lastname2.'</span>';
        }
        else{
            $lastname2 = getLastname($pdo, $chat['sender']);
            $lastname = '<span class="chat__name d-flex">'.$lastname2.'</span>';
        }
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
            echo '<li class="chat__item d-flex chat-my">
                    <div class="chat__header d-flex">
                        <div class="chat__photo">
                            <img src="#">
                        </div>
                        <span class="chat__name d-flex">احمدی</span>
                        <div class="chat__date d-flex">
                            <span class="chat__day">' . $ago . '</span>
                            <span>،</span>
                            <span class="chat__time">' . $HM . '</span>
                        </div>
                    </div>
                    <div class="chat__body">
                        ' . $message . '
                    </div>
                </li>';
        }
        else {
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
            echo '<li class="chat__item d-flex chat-other">
                    <div class="chat__header d-flex">
                        <div class="chat__photo">
                            <img src="' . $profilePath . '">
                            </div>
                            '.$lastname.'
                            <div class="chat__date d-flex">
                                <span class="chat__day">' . $ago . '</span>
                                <span>،</span>
                                <span class="chat__time">' . $HM . '</span>
                            </div>
                        </div>
                        <div class="chat__body '.$verifyclass.'">
                            ' . $message . '
                        </div>
                    </li>';
        }
    }
}
echo '

</ul>

</div>
';
$chat_day = '';
?>
