<?php
include_once 'jdf.php';
include_once 'goodzip.inc.php';
function emptyInputSignup($name, $lastname, $pwd, $pwdRepeat, $phone)
{
    $result = null;
    if (empty($name) || empty($lastname) || empty($pwd) || empty($pwdRepeat) || empty($phone)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
function emptyInputLogin($username, $pwd)
{
    $result = null;
    if (empty($pwd) || empty($username)) {
        # code...
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
function invalidName($name)
{
    $result = null;
    if (!preg_match('/^[پچجحخهعغفقثصضشسیبلاتنمکگوئدذرزطظژؤإأءًٌٍَُِّآا\s]+$/u', $name)) {
        # code...
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
function invalidLastname($lastname)
{
    $result = null;
    if (!preg_match('/^[پچجحخهعغفقثصضشسیبلاتنمکگوئدذرزطظژؤآاإأءًٌٍَُِّ\s]+$/u', $lastname)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
function invalidPassword($pwd)
{
    $result = null;
    if (strlen($pwd) < 6) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
function passwordMatch($pwd, $pwdRepeat)
{
    $result = null;
    if ($pwd !== $pwdRepeat) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
function invalidPhone($phone)
{
    $result = null;
    if (strlen($phone) != 10) {
        $result = true;
    } else {
        $result = false;
        return $result;
    }
}
function phoneExists($pdo, $phone)
{
    $sql = "SELECT * FROM account Where ac_username = ?;";
    $stmt = $pdo->prepare($sql);
    $exist = $stmt->execute([$phone]);
    $row = $stmt->fetch();
    if (!$exist) {
        header("location: ../php/signup.php?error=phonetaken");
        exit();
    }
    if ($row) {
        return $row;
    } else {
        $result = false;
        return $result;
    }
    $stmt = null;
}
function createUser($pdo, $name, $lastname, $pwd, $phone)
{
    $date = jdate('Y-m-d');
    $access = 0;
    $pwd_hash = password_hash($pwd, PASSWORD_DEFAULT);

    $stmt = null;
    $sql = "INSERT INTO account(ac_username,ac_password,ac_firstname,ac_lastname,ac_access,ac_createdate,ac_apartment) VALUES (?,?,?,?,?,?,?);";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$phone, $pwd_hash, $name, $lastname, $access, $date, 0]);
    if (!$result) {
        header("location:../php/signup.php?error=createAC_failed");
        exit();
    }
    $source = '../data/profile.jpg';
    // Store the path of destination file
    $destination = "../data/users/" . $phone . '/profile.jpg';
    createFolder("../data/users/" . $phone);
    copy($source, $destination);
    header("location:../php/signup.php?error=none");
    exit();
}
function createUserFolder($username)
{
    $result = null;
    $path = "../data/users/" . $username . "/";
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
        $source = '/building-managment/data/profile.jpg';
        $destination = '/building-managment/data/users/' . $username . 'profile.jpg';
        // var_dump($path);
        // var_dump($source);
        // var_dump($destination);
        if (!copy($source, $destination)) {
            echo "File can't be copied! \n";
            $result = false;
        } else {
            echo "File has been copied! \n";
            $result = true;
        }
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
function loginUser($pdo, $username, $pwd)
{
    $user = phoneExists($pdo, $username);
    if ($user === false) {
        header("location:../php/login.php?error=InvalidUsername");
        exit();
    }
    $pwdHashed = $user["ac_password"];
    $checkpwd = password_verify($pwd, $pwdHashed);
    if ($checkpwd === false) {
        header('location:../php/login.php?error=wrongpassword');
        exit();
    } else if ($checkpwd === true) {

        // echo "it works";
        // echo '<br>';
        $sql = "SELECT * FROM account WHERE ac_username = ?;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username]);
        $userAccess = $stmt->fetch();
        session_start();
        $_SESSION['nothashedPass'] = $pwd;
        $_SESSION['logged-in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['userAccess'] = $userAccess['ac_access'];
        if (isAdmin($userAccess['ac_access'])) {
            echo "<script>window.alert('ورود به حساب کاربری با موفقیت انجام شد');</script>";
            echo ("<script type='text/javascript'>
            location.replace(\"/building-managment/php/admin-dashboard.php\");
            </script>");
            exit();
        } else {
            $userid = $_SESSION['username'];
            echo "<script>window.alert('ورود به حساب کاربری با موفقیت انجام شد');</script>";
            echo ("<script type='text/javascript'>
            location.replace(\"/building-managment/php/user-dashboard.php\");
            </script>");
            exit();
        }
    }
}
function isAdmin($access)
{
    $result = null;
    if ($access == '1') {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function getUserData($pdo, $userid)
{
    $result = null;
    $sql = "SELECT * FROM account WHERE ac_username = ?";
    $stmt = $pdo->prepare($sql);
    $exist = $stmt->execute([$userid]);
    if (!$exist) {
        $result = false;
    } else {
        $rowaccount = $stmt->fetch();
        $ap_number = $rowaccount['ac_apartment'];
        $sql = "SELECT * FROM account WHERE ac_username = ?";
        $stmt2 = $pdo->prepare("SELECT COUNT(*) FROM `message` WHERE receiver= ? AND verify= ?;");
        $stmt2->execute(['1', '0']);
        $_SESSION['notfBadge'] = $stmt2->fetchColumn();
        $_SESSION['notfBadge'] += $pdo->query("SELECT COUNT(*) FROM `message` WHERE receiver= $userid AND verify= '0';")->fetchColumn();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userid]);
        $rowperson = $stmt->fetch();
        $_SESSION['urent'] = number_format($rowaccount['ac_rent']);
        $_SESSION['ucharge'] = number_format($rowaccount['ac_charge']);
        $_SESSION['ucredit'] = number_format($rowaccount['ac_credit']);
        $_SESSION['udebit'] = number_format($rowaccount['ac_debit']);
        $_SESSION['uapartment'] = $rowaccount['ac_apartment'];
        $_SESSION["upassword"] = $rowaccount["ac_password"];
        $_SESSION['ufirstname'] = $rowperson['ac_firstname'];
        $_SESSION['ulastname'] = $rowperson['ac_lastname'];
        $_SESSION['uphone'] = $rowperson['ac_username'];
        $_SESSION['uid'] = $rowperson['ac_codemelli'];
        $_SESSION['uage'] = $rowperson['ac_age'];
        $_SESSION['ugender'] = $rowperson['ac_gender'];
        if (isAdmin($rowperson['ac_access'])) {
            # code...
            $path = "../data/admin/" . $userid . "/profile.jpg";
            if (file_exists($path)) {
                $_SESSION['uprofile'] = $path;
            } else {
                $_SESSION['uprofile'] = "../data/profile.jpg";
            }
        } else {
            $_SESSION['uprofile'] = "../data/users/" . $userid . "/profile.jpg";
            $sql = "SELECT * FROM apartment WHERE ap_number = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$ap_number]);
            $rowapartment = $stmt->fetch();
            $_SESSION['uwaterid'] = (empty($rowapartment['ap_waterid'])) ? "0" : $rowapartment['ap_waterid'];
            $_SESSION['upowerid'] = (empty($rowapartment['ap_powerid'])) ? "0" : $rowapartment['ap_powerid'];
            $_SESSION['ugasid'] = (empty($rowapartment['ap_gasid'])) ? "0" : $rowapartment['ap_gasid'];
            $_SESSION['upeople'] = (empty($rowapartment['ap_people'])) ? "0" : $rowapartment['ap_people'];
        }
        $result = true;
        // $_SESSION['path'] = $path;
        // $photoaddres = $path;

    }
    return $result;
}

function createFolder($path)
{
    // $folderName = 'images/gallery';
    // $config['upload_path'] = $folderName;
    if (!is_dir($path)) {
        mkdir($path, 0777);
    }
}

function showUserHistoryData($pdo, $username, $sql, $ascdesc)
{

    echo '
<table class="table">
<thead>
    <tr>
        <th><a href="?sort=date&mode=' . $ascdesc . '">تاریخ پرداخت</a></th>
        <th><a href="?sort=price&mode=' . $ascdesc . '">قیمت</a></th>
        <th><a href="?sort=info&mode=' . $ascdesc . '">توضیحات</a></th>
        <th><a href="?sort=status&mode=' . $ascdesc . '">وضعیت پرداخت</a></th>
    </tr>
</thead>
<tbody>
';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    while ($row = $stmt->fetch()) :
        $status = getStatusOrder($pdo, $row['orders']);
        if ($status == 'منقضی شد') {
            echo '
        <tr>
            <td style="direction:ltr">' . $row['date'] . ' </td>
            <td>' . number_format($row['price']) . '  تومان</td>
            <td>' . $row['info'] . ' </td>
            <td class="expired">' . $status . ' </td>
        </tr>
        ';
        }
        if ($status == 'پرداخت موفق') {
            echo '
        <tr>
            <td style="direction:ltr">' . $row['date'] . ' </td>
            <td>' . number_format($row['price']) . '  تومان</td>
            <td>' . $row['info'] . ' </td>
            <td class="success">' . $status . ' </td>
        </tr>
        ';
        }
        if ($status == 'پرداخت ناموفق') {
            echo '
        <tr>
            <td style="direction:ltr">' . $row['date'] . ' </td>
            <td>' . number_format($row['price']) . '  تومان</td>
            <td>' . $row['info'] . ' </td>
            <td class="failed">' . $status . ' </td>
        </tr>
        ';
        }
        if ($status == 'در انتظار پرداخت') {
            echo '
        <tr>
            <td style="direction:ltr">' . $row['date'] . ' </td>
            <td>' . number_format($row['price']) . '  تومان</td>
            <td>' . $row['info'] . ' </td>
            <td class="warning">' . $status . ' </td>
        </tr>
        ';
        }

    endwhile;

    echo '
</tbody>
</table>
';
}

function getStatusOrder($pdo, $id)
{
    $sql = "SELECT order_verify FROM `orders` WHERE order_id = ?;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetchColumn();
}

function insertRadioGender()
{
    $gender = $_SESSION['ugender'];
    if ($gender === 1) {
        # code...
        echo '<input type="radio" name="gender" value="1" checked>
        <label for="gender">مرد</label>
        <input type="radio" name="gender" value="2">
        <label for="gender">زن</label>';
    } else if ($gender === 2) {
        echo '<input type="radio" name="gender" value="1">
        <label for="gender">مرد</label>
        <input type="radio" name="gender" value="2" checked>
        <label for="gender">زن</label>';
    } else {
        echo '<input type="radio" name="gender" value="1">
        <label for="gender">مرد</label>
        <input type="radio" name="gender" value="2">
        <label for="gender">زن</label>';
    }
}
function updateUserData($pdo, $userid, $ufirtsname, $ulastname, $uage, $ugender, $ucodemeli, $uapartment, $upwd)
{
    $result = null;
    $upwd = password_hash($upwd, PASSWORD_DEFAULT);
    $sql = "UPDATE account SET ac_password=:pwd, ac_apartment=:apartment WHERE ac_username=:username;";
    $stmt = $pdo->prepare($sql);
    $exist = $stmt->execute(array(":pwd" => $upwd, ":apartment" => $uapartment, ":username" => $userid));
    if (!$exist) {
        $result = false;
        exit();
    } else {
        $sql = "UPDATE account SET ac_firstname=:firstname, ac_lastname=:lastname, ac_codemelli=:id, ac_age=:age, ac_gender=:gender WHERE ac_username=:username; ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(":firstname" => $ufirtsname, ":lastname" => $ulastname, ":id" => $ucodemeli, ":age" => $uage, ":gender" => $ugender, ":username" => $userid));
        $result = true;
    }
    return $result;
}

function updateVerify($pdo, $username)
{

    $sql = 'UPDATE `message` SET `message`.`verify` = ? WHERE `receiver` = ?;';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['1', $username]);
}


function uploadfile($filearray, $targetPath, $filename = "")
{
    $result = array('error' => false, 'name' => '', 'extension' => '', 'path' => '');
    // get details of the uploaded file
    $fileTmpPath = $filearray['tmp_name'];
    $fileName = $filearray['name'];
    // $fileSize = $filearray['size'];
    // $fileType = $filearray['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));
    $result['extension'] = $fileExtension;

    // sanitize file-name
    if ($filename === "") {
        $result['name'] = $fileName;
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
    } else {
        $result['name'] = $filename;
        $newFileName = $filename . '.' . $fileExtension;

        echo "enter function<br>";
        var_dump($filename);
        var_dump($newFileName);
    }
    // check if file has one of the following extensions
    $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc', 'pdf', 'mkv', 'mp4', 'mp3', 'rar');
    if (in_array($fileExtension, $allowedfileExtensions)) {
        // directory in which the uploaded file will be moved
        $uploadFileDir = $targetPath;
        $dest_path = $uploadFileDir . $newFileName;
        $result['path'] = $dest_path;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $result['error'] = true;
        }
        // else {
        //     $result = false;
        // }
    }
    // else {
    //     $result = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
    //     $result = false;
    // }
    return $result;
}

function getLastname($pdo, $username)
{
    $sql =  "SELECT * FROM `account` WHERE ac_username=?;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $row = $stmt->fetch();
    return $row['ac_lastname'];
}

function getFirstname($pdo, $username)
{
    $sql =  "SELECT * FROM `account` WHERE ac_username=?;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $row = $stmt->fetch();
    return $row['ac_firstname'];
}

function getProfile($pdo, $username)
{
    $stmt = $pdo->prepare("SELECT ac_access FROM account WHERE ac_username = ?;");
    $stmt->execute([$username]);
    $data = $stmt->fetch();
    if ($data['ac_access'] == '1') {
        return "../data/admin/" . $username . "/profile.jpg";
    } else {
        return "../data/users/" . $username . "/profile.jpg";
    }
}

function getFilePath($pdo, $id)
{
    $sql = "SELECT * FROM `file` WHERE id=?;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $path = $stmt->fetchColumn(4); #path(data) is in 4th column of 'file' table
    return $path;
}

function getFileName($pdo, $id)
{
    $sql = "SELECT * FROM `file` WHERE id=?;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $path = $stmt->fetchColumn(2); #name(data) is in 2th column of 'file' table
    return $path;
}

function getHMS($date)
{
    return date("H:i:s", strtotime($date));
}

function getYMD($date)
{
    $jy = date("Y", strtotime($date));
    $jm = date("m", strtotime($date));
    $jd = date("d", strtotime($date));
    $datetime = jalali_to_gregorian($jy, $jm, $jd, "-");

    return date("Y-m-d", strtotime($datetime));
}

function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime("now", new DateTimeZone("Asia/Tehran"));
    // $now = jdate('Y-m-d');
    // $jy = date("Y",strtotime($datetime));
    // $jm = date("m",strtotime($datetime));
    // $jd = date("d",strtotime($datetime));
    // $datetime = jalali_to_gregorian($jy,$jm,$jd);
    $ago = new DateTime($datetime, new DateTimeZone("Asia/Tehran"));
    // $ago = date("Y-m-d",strtotime($datetime));
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        // 'y' => 'year',
        // 'm' => 'month',
        // 'w' => 'week',
        // 'd' => 'day',
        // 'h' => 'hour',
        // 'i' => 'minute',
        // 's' => 'second',

        'y' => 'سال',
        'm' => 'ماه',
        'w' => 'هفته',
        'd' => 'روز',
        'h' => 'ساعت',
        'i' => 'دقیقه',
        's' => 'ثانیه',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(' و ', $string) . ' قبل' : 'همین حالا';
}

function accountTable($pdo, $limit)
{
    $searchData = (empty($_SESSION['search'])) ? "" : $_SESSION['search'];
    if (empty($sort)) {
        $sort = 'ac_username';
    }
    if (empty($ascdesc)) {
        # code...
        $ascdesc = 'ASC';
    }
    try {
        if (empty($searchData)) {

            $total = $pdo->query('
            SELECT
                COUNT(*)
            FROM
                `account`
            ')->fetchColumn();
        } else {
            $total = $pdo->query("
                SELECT
                    COUNT(*)
                FROM
                    `account`
                WHERE
                (`ac_firstname` LIKE '%$searchData%') OR (`ac_lastname` LIKE '%$searchData%')
                OR (`ac_apartment` LIKE '%$searchData%') OR (`ac_rent` LIKE '%$searchData%')
                OR (`ac_charge` LIKE '%$searchData%') OR (`ac_debit` LIKE '%$searchData%') OR (`ac_credit` LIKE '%$searchData%')
                ")->fetchColumn();
        }

        if ($total == 0) {
            $limit = 0;

            // How many pages will there be
            $pages = 0;

            // What page are we currently on?
            $page = 0;

            // Calculate the offset for the query
            $offset = ($page - 1)  * $limit;
        } else {


            // How many pages will there be
            $pages = ceil($total / $limit);

            // What page are we currently on?
            $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
                'options' => array(
                    'default'   => 1,
                    'min_range' => 1,
                ),
            )));

            // Calculate the offset for the query
            $offset = ($page - 1)  * $limit;
        }

        // Prepare the paged query
        if (!empty($searchData)) {
            $stmt = $pdo->prepare("
            SELECT
                *
            FROM
                `account`
            WHERE
            (`ac_firstname` LIKE '%$searchData%') OR (`ac_lastname` LIKE '%$searchData%')
            OR (`ac_apartment` LIKE '%$searchData%') OR (`ac_rent` LIKE '%$searchData%')
            OR (`ac_charge` LIKE '%$searchData%') OR (`ac_debit` LIKE '%$searchData%') OR (`ac_credit` LIKE '%$searchData%')
            ORDER BY
                " . $_SESSION['tabSort'] . " " . $_SESSION['ascdesc'] . "
            LIMIT
                :limit
            OFFSET
                :offset
        ");
        } else {
            $stmt = $pdo->prepare("
                SELECT
                    *
                FROM
                    `account`
                ORDER BY
                " . $_SESSION['tabSort'] . " " . $_SESSION['ascdesc'] . "
                LIMIT
                    :limit
                OFFSET
                    :offset
            ");
        }

        // Bind the query params
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        // Do we have any results?
        if ($stmt->rowCount() > 0) {
            // Define how we want to fetch the results
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            $iterator = new IteratorIterator($stmt);
            echo '
            <table class="admin-table">
                <thead>
                    <tr>
                        <th><a class="" href="?tab=account&sort=id&mode=' . $_SESSION['ascdesc'] . '">شناسه</a></th>
                        <th><a class="" href="?tab=account&sort=name&mode=' . $_SESSION['ascdesc'] . '">نام</a></th>
                        <th><a class="" href="?tab=account&sort=lastname&mode=' . $_SESSION['ascdesc'] . '">نام خانوادگی</a></th>
                        <th><a class="" href="?tab=account&sort=apartment&mode=' . $_SESSION['ascdesc'] . '">شماره واحد</a></th>
                        <th><a class="" href="?tab=account&sort=rent&mode=' . $_SESSION['ascdesc'] . '">اجاره</a></th>
                        <th><a class="" href="?tab=account&sort=charge&mode=' . $_SESSION['ascdesc'] . '">شارژ</a></th>
                        <th><a class="" href="?tab=account&sort=debit&mode=' . $_SESSION['ascdesc'] . '">بدهی</a></th>
                        <th><a class="" href="?tab=account&sort=credit&mode=' . $_SESSION['ascdesc'] . '">بستانکاری</a></th>
                        <th><a class="" href="?tab=account&sort=status&mode=' . $_SESSION['ascdesc'] . '">وضعیت</a></th>
                    </tr>
                </thead>
                <tbody>
            ';


            $userIds = array();


            // Display the results
            foreach ($iterator as $row) {
                // echo $row['ac_username'];
                if (!isAdmin($row['ac_access'])) {
                    # code...
                    // $stmt = $pdo->prepare("SELECT * FROM `apartment` WHERE `ap_number` = ? ");
                    // $stmt->execute([$row['ac_apartment']]);
                    // $data = $stmt->fetch();
                    if ($row['ac_status'] == '1') {
                        echo '
                            <tr>
                                <td><input class="inpnostyle" type="text" name="ac_username[]" value="' . $row['ac_username'] . '" ></td>
                                <td><input class="inpnostyle" type="text" name="ac_firstname[]" value="' . $row['ac_firstname'] . '" ></td>
                                <td><input class="inpnostyle" type="text" name="ac_lastname[]" value="' . $row['ac_lastname'] . '" ></td>
                                <td><input class="inpnostyle" type="text" name="ac_apartment[]" value="' . $row['ac_apartment'] . '" ></td>
                                <td><input class="inpnostyle" type="text" name="ac_rent[]" value="' . number_format($row['ac_rent']) . '"></td>
                                <td><input class="inpnostyle" type="text" name="ac_charge[]" value="' . number_format($row['ac_charge']) . '"></td>
                                <td><input class="inpnostyle" type="text" name="ac_debit[]" value="' . number_format($row['ac_debit']) . '"></td>
                                <td><input class="inpnostyle" type="text" name="ac_credit[]" value="' . number_format($row['ac_credit']) . '"></td>
                                <td><select class="admin-select-account" type="text" name="ac_status[]">
                                <option class="clr-success" selected value="1">فعال</option>
                                <option class="clr-danger" value="0">غیر فعال</option>
                                </td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="delete[]" value="' . $row['ac_username'] . '">
                                        <span class="slider"></span>
                                    </label>
                                </td>
                            </tr>
                            ';
                    } else {
                        echo '
                            <tr>
                                <td><input class="inpnostyle" type="text" name="ac_username[]" value="' . $row['ac_username'] . '" ></td>
                                <td><input class="inpnostyle" type="text" name="ac_firstname[]" value="' . $row['ac_firstname'] . '" ></td>
                                <td><input class="inpnostyle" type="text" name="ac_lastname[]" value="' . $row['ac_lastname'] . '" ></td>
                                <td><input class="inpnostyle" type="text" name="ac_apartment[]" value="' . $row['ac_apartment'] . '" ></td>
                                <td><input class="inpnostyle" type="text" name="ac_rent[]" value="' . $row['ac_rent'] . '"></td>
                                <td><input class="inpnostyle" type="text" name="ac_charge[]" value="' . $row['ac_charge'] . '"></td>
                                <td><input class="inpnostyle" type="text" name="ac_debit[]" value="' . $row['ac_debit'] . '"></td>
                                <td><input class="inpnostyle" type="text" name="ac_credit[]" value="' . $row['ac_credit'] . '"></td>
                                <td><select class="admin-select-account" type="text" name="ac_status[]">
                                <option class="clr-success" value="1">فعال</option>
                                <option class="clr-danger" selected value="0">غیر فعال</option>
                                </td>>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="delete[]" value="' . $row['ac_username'] . '">
                                        <span class="slider"></span>
                                    </label>
                                </td>
                            </tr>
                            ';
                    }
                }
            }

            if (!empty($userIds)) {
                # code...
                $_SESSION['userIDs'] = $userIds;
            }

            echo '
            </tbody>
            </table>
            ';
            $querystring = (empty($_SESSION['sort'])) ? 'tab=account' : 'tab=account&sort' . $_SESSION['sort'] . '&mode=' . $_SESSION['ascdesc'] . '';
            // Some information to display to the user
            $start = $offset + 1;
            $end = min(($offset + $limit), $total);

            // The "back" link
            $prevlink = ($page > 1) ? '<a class="page-item" href="?' . $querystring . '&page=1" title="First page">شروع</a> <a class="page-item" href="?' . $querystring . '&page=' . ($page - 1) . '" title="Previous page">قبلی</a>' : '<span class="disabled page-item">شروع</span> <span class="disabled page-item">قبلی</span>';

            // The "forward" link
            $nextlink = ($page < $pages) ? '<a class="page-item" href="?' . $querystring . '&page=' . ($page + 1) . '" title="Next page">بعدی</a> <a class="page-item" href="?' . $querystring . '&page=' . $pages . '" title="Last page">پایان</a>' : '<span class="disabled page-item">بعدی</span> <span class="disabled page-item">پایان</span>';


            //pagesinfo
            $pagesinfo = '<span class="pageinfo"> صفخه ' . $page . ' از ' . $pages . ' ، نمایش ' . $start . ' تا ' . $end . ' از ' . $total . ' نتیجه</span>';
            // Display the paging information
            echo '<div id="paging" class="admin-table-pagination"><p>', $prevlink, $pagesinfo, $nextlink, ' </p></div>';
        } else {
            echo '<p>متاسفانه نتیجه ای با این عبارت یافت نشد!</p>';
        }
    } catch (Exception $e) {
        echo '<p>', $e->getMessage(), '</$row>';
    }
}

function apartmentTable($pdo, $limit)
{
    $status_ac = '1';
    $searchData = (empty($_SESSION['search'])) ? "" : $_SESSION['search'];
    if (empty($sort)) {
        $sort = 'ap_number';
    }
    if (empty($ascdesc)) {
        # code...
        $ascdesc = 'ASC';
    }
    try {
        if (empty($searchData)) {

            $total = $pdo->query('
            SELECT
                COUNT(*)
            FROM
                `apartment`
            ')->fetchColumn();
        } else {
            $total1 = $pdo->query("
                SELECT
                    COUNT(*)
                FROM
                    `apartment`
                WHERE
                (`ap_number` LIKE '%$searchData%') OR (`ap_people` LIKE '%$searchData%')
                OR (`ap_parkingid` LIKE '%$searchData%') OR (`ap_waterid` LIKE '%$searchData%')
                OR (`ap_powerid` LIKE '%$searchData%') OR (`ap_gasid` LIKE '%$searchData%')
                ")->fetchColumn();

            $total2 = $pdo->query("
                SELECT
                    COUNT(*)
                FROM
                    `account`
                WHERE
                `ac_status` = '.$status_ac.' AND
                (`ac_firstname` LIKE '%$searchData%') OR (`ac_lastname` LIKE '%$searchData%')
                ")->fetchColumn();

            $total = $total1 + $total2;
        }
        if ($total == 0) {
            $limit = 0;

            // How many pages will there be
            $pages = 0;

            // What page are we currently on?
            $page = 0;

            // Calculate the offset for the query
            $offset = ($page - 1)  * $limit;
        } else {


            // How many pages will there be
            $pages = ceil($total / $limit);

            // What page are we currently on?
            $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
                'options' => array(
                    'default'   => 1,
                    'min_range' => 1,
                ),
            )));

            // Calculate the offset for the query
            $offset = ($page - 1)  * $limit;
        }

        // Prepare the paged query
        if (!empty($searchData)) {
            $stmt = $pdo->prepare("
            SELECT
                *
            FROM
                `apartment`
            LEFT JOIN `account`
            ON `apartment`.`ap_number` = `account`.`ac_apartment`
            WHERE
            (`ap_number` LIKE '%$searchData%') OR (`ap_people` LIKE '%$searchData%')
                OR (`ap_parkingid` LIKE '%$searchData%') OR (`ap_waterid` LIKE '%$searchData%')
                OR (`ap_powerid` LIKE '%$searchData%') OR (`ap_gasid` LIKE '%$searchData%')
                OR (`ac_firstname` LIKE '%$searchData%') OR (`ac_lastname` LIKE '%$searchData%')
            ORDER BY
                " . $_SESSION['tabSort'] . " " . $_SESSION['ascdesc'] . "
            LIMIT
                :limit
            OFFSET
                :offset
        ");
        } else {
            $stmt = $pdo->prepare("
                SELECT
                    *
                FROM
                    `apartment`
                LEFT JOIN `account`
                ON `apartment`.`ap_number` = `account`.`ac_apartment`
                ORDER BY
                " . $_SESSION['tabSort'] . " " . $_SESSION['ascdesc'] . "
                LIMIT
                    :limit
                OFFSET
                    :offset
            ");
        }

        // Bind the query params
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $userIds = array();

        // Do we have any results?
        if ($stmt->rowCount() > 0) {
            // Define how we want to fetch the results
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $iterator = new IteratorIterator($stmt);

            echo '
            <table class="admin-table">
                <thead>
                    <tr>
                        <th><a class="" href="?tab=apartment&sort=name&mode=' . $_SESSION['ascdesc'] . '">نام</a></th>
                        <th><a class="" href="?tab=apartment&sort=lastname&mode=' . $_SESSION['ascdesc'] . '">نام خانوادگی</a></th>
                        <th><a class="" href="?tab=apartment&sort=apartment&mode=' . $_SESSION['ascdesc'] . '">شماره واحد</a></th>
                        <th><a class="" href="?tab=apartment&sort=people&mode=' . $_SESSION['ascdesc'] . '">افراد</a></th>
                        <th><a class="" href="?tab=apartment&sort=parking&mode=' . $_SESSION['ascdesc'] . '">پارکینگ</a></th>
                        <th><a class="" href="?tab=apartment&sort=waterid&mode=' . $_SESSION['ascdesc'] . '">شناسه آب</a></th>
                        <th><a class="" href="?tab=apartment&sort=powerid&mode=' . $_SESSION['ascdesc'] . '">شناسه برق</a></th>
                        <th><a class="" href="?tab=apartment&sort=gasid&mode=' . $_SESSION['ascdesc'] . '">شناسه گاز</a></th>
                    </tr>
                </thead>
                <tbody>
            ';


            // Display the results
            foreach ($iterator as $row) {
                // echo $row['ac_username'];
                if (!isAdmin($row['ac_access'])) {
                    # code...
                    // $stmt = $pdo->prepare("SELECT * FROM `apartment` WHERE `ap_number` = ? ");
                    // $stmt->execute([$row['ac_apartment']]);
                    // $data = $stmt->fetch();
                    array_push($userIds, $row['ac_username']);
                    echo '
                <tr>
                    <td class="noteditable"><input class="inpnostyle" type="text" name="ap_firstname[]" value="' . $row['ac_firstname'] . '" readonly></td>
                    <td class="noteditable"><input class="inpnostyle" type="text" name="ap_lastname[]" value="' . $row['ac_lastname'] . '" readonly></td>
                    <td class="noteditable"><input class="inpnostyle" type="text" name="ap_apartment[]" value="' . $row['ap_number'] . '" readonly></td>
                    <td><input class="inpnostyle" type="text" name="ap_people[]" value="' . $row['ap_people'] . '"></td>
                    <td><input class="inpnostyle" type="text" name="ap_parkingid[]" value="' . $row['ap_parkingid'] . '"></td>
                    <td><input class="inpnostyle" type="text" name="ap_waterid[]" value="' . $row['ap_waterid'] . '"></td>
                    <td><input class="inpnostyle" type="text" name="ap_powerid[]" value="' . $row['ap_powerid'] . '"></td>
                    <td><input class="inpnostyle" type="text" name="ap_gasid[]" value="' . $row['ap_gasid'] . '"></td>
                    <td>
                        <label class="switch">
                            <input type="checkbox" name="delete[]" value="' . $row['ap_number'] . '">
                            <span class="slider"></span>
                        </label>
                    </td>
                </tr>
                ';
                }
            }


            if (!empty($userIds)) {
                # code...
                $_SESSION['userIDs'] = $userIds;
            }

            echo '
            </tbody>
            </table>
            ';


            // Some information to display to the user
            $start = $offset + 1;
            $end = min(($offset + $limit), $total);

            // The "back" link
            $prevlink = ($page > 1) ? '<a class="page-item" href="?tab=' . $_SESSION['tab'] . '&page=1" title="First page">شروع</a> <a class="page-item" href="?tab=' . $_SESSION['tab'] . '&page=' . ($page - 1) . '" title="Previous page">قبلی</a>' : '<span class="disabled page-item">شروع</span> <span class="disabled page-item">قبلی</span>';

            // The "forward" link
            $nextlink = ($page < $pages) ? '<a class="page-item" href="?tab=' . $_SESSION['tab'] . '&page=' . ($page + 1) . '" title="Next page">بعدی</a> <a class="page-item" href="?tab=' . $_SESSION['tab'] . '&page=' . $pages . '" title="Last page">پایان</a>' : '<span class="disabled page-item">بعدی</span> <span class="disabled page-item">پایان</span>';


            //pagesinfo
            $pagesinfo = '<span class="pageinfo"> صفخه ' . $page . ' از ' . $pages . ' ، نمایش ' . $start . ' تا ' . $end . ' از ' . $total . ' نتیجه</span>';
            // Display the paging information
            echo '<div id="paging" class="admin-table-pagination"><p>', $prevlink, $pagesinfo, $nextlink, ' </p></div>';
        } else {
            echo '<p>متاسفانه نتیجه ای با این عبارت یافت نشد!</p>';
        }
    } catch (Exception $e) {
        echo '<p>', $e->getMessage(), '</$row>';
    }
}

function reportTable($pdo, $limit)
{
    $searchData = (empty($_SESSION['search'])) ? "" : $_SESSION['search'];
    if (empty($sort)) {
        $sort = 'date';
    }
    if (empty($ascdesc)) {
        # code...
        $ascdesc = 'DESC';
    }
    try {
        if (empty($searchData)) {

            $total = $pdo->query('
            SELECT
                COUNT(*)
            FROM
                `tran`
            ')->fetchColumn();
        } else {
            $total1 = $pdo->query("
                SELECT
                    COUNT(*)
                FROM
                    `tran`
                WHERE
                (`price` LIKE '%$searchData%') OR (`info` LIKE '%$searchData%')
                OR (`date` LIKE '%$searchData%')
                ")->fetchColumn();

            $total2 = $pdo->query("
                SELECT
                    COUNT(*)
                FROM
                    `account`
                WHERE
                (`ac_firstname` LIKE '%$searchData%') OR (`ac_lastname` LIKE '%$searchData%')
                ")->fetchColumn();

            $total3 = $pdo->query("
                SELECT
                    COUNT(*)
                FROM
                    `orders`
                WHERE
                (`order_verify` LIKE '%$searchData%')
                ")->fetchColumn();

            $total = $total1 + $total2 + $total3;
        }
        if ($total == 0) {
            $limit = 0;

            // How many pages will there be
            $pages = 0;

            // What page are we currently on?
            $page = 0;

            // Calculate the offset for the query
            $offset = ($page - 1)  * $limit;
        } else {


            // How many pages will there be
            $pages = ceil($total / $limit);

            // What page are we currently on?
            $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
                'options' => array(
                    'default'   => 1,
                    'min_range' => 1,
                ),
            )));

            // Calculate the offset for the query
            $offset = ($page - 1)  * $limit;
        }

        // Prepare the paged query
        if (!empty($searchData)) {
            $stmt = $pdo->prepare("
            SELECT
                *
            FROM
                `tran`
            INNER JOIN `account`
            ON `tran`.`username` = `account`.`ac_username`
            INNER JOIN `orders`
            ON `tran`.`orders` = `orders`.`order_id`
            WHERE
            (`ac_firstname` LIKE '%$searchData%') OR (`ac_lastname` LIKE '%$searchData%')
                OR (`price` LIKE '%$searchData%') OR (`info` LIKE '%$searchData%')
                OR (`date` LIKE '%$searchData%') OR (`order_verify` LIKE '%$searchData%')
            ORDER BY
                " . $_SESSION['tabSort'] . " " . $_SESSION['ascdesc'] . "
            LIMIT
                :limit
            OFFSET
                :offset
        ");
        } else {
            $stmt = $pdo->prepare("
                SELECT
                    *
                FROM
                    `tran`
                JOIN `account`
                ON `tran`.`username` = `account`.`ac_username`
                JOIN `orders`
                ON `tran`.`orders` = `orders`.`order_id`
                ORDER BY
                " . $_SESSION['tabSort'] . " " . $_SESSION['ascdesc'] . "
                LIMIT
                    :limit
                OFFSET
                    :offset
            ");
        }

        // Bind the query params
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $userIds = array();

        // Do we have any results?
        if ($stmt->rowCount() > 0) {
            // Define how we want to fetch the results
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $iterator = new IteratorIterator($stmt);

            echo '
            <table class="admin-table">
                <thead>
                    <tr>
                        <th><a class="" href="?tab=report&sort=name&mode=' . $_SESSION['ascdesc'] . '">نام</a></th>
                        <th><a class="" href="?tab=report&sort=lastname&mode=' . $_SESSION['ascdesc'] . '">نام خانوادگی</a></th>
                        <th><a class="" href="?tab=report&sort=price&mode=' . $_SESSION['ascdesc'] . '">مبلغ</a></th>
                        <th><a class="" href="?tab=report&sort=info&mode=' . $_SESSION['ascdesc'] . '">توضیحات</a></th>
                        <th><a class="" href="?tab=report&sort=order&mode=' . $_SESSION['ascdesc'] . '">وضعیت</a></th>
                        <th><a class="" href="?tab=report&sort=date&mode=' . $_SESSION['ascdesc'] . '">تاریخ</a></th>
                    </tr>
                </thead>
                <tbody>
            ';


            // Display the results
            foreach ($iterator as $row) {
                // echo $row['ac_username'];
                if (!isAdmin($row['ac_access'])) {
                    # code...
                    // $stmt = $pdo->prepare("SELECT * FROM `apartment` WHERE `ap_number` = ? ");
                    // $stmt->execute([$row['ac_apartment']]);
                    // $data = $stmt->fetch();
                    array_push($userIds, $row['id']);
                    if ($row['order_verify'] == "منقضی شد") {
                        $class = 'expired';
                    }
                    if ($row['order_verify'] == "پرداخت موفق") {
                        $class = 'success';
                    }
                    if ($row['order_verify'] == "پرداخت ناموفق") {
                        $class = 'failed';
                    }
                    if ($row['order_verify'] == "در انتظار پرداخت") {
                        $class = 'warning';
                    }
                    echo '
                <tr>
                    <td class="noteditable"><input class="inpnostyle" type="text" name="r_firstname[]" value="' . $row['ac_firstname'] . '" readonly></td>
                    <td class="noteditable"><input class="inpnostyle" type="text" name="r_lastname[]" value="' . $row['ac_lastname'] . '" readonly></td>
                    <td><input class="inpnostyle" type="text" name="r_price[]" value="' . number_format($row['price']) . '"></td>
                    <td><input class="inpnostyle" type="text" name="r_info[]" value="' . $row['info'] . '"></td>
                    <td><input class="inpnostyle ' . $class . '" type="text" name="r_verify[]" value="' . $row['order_verify'] . '"></td>
                    <td><input class="inpnostyle" style="direction:ltr;" type="text" name="r_date[]" value="' . $row['date'] . '"></td>
                    <td>
                        <label class="switch">
                            <input type="checkbox" name="delete[]" value="' . $row['orders'] . '">
                            <span class="slider"></span>
                        </label>
                    </td>
                </tr>
                ';
                }
            }


            if (!empty($userIds)) {
                # code...
                $_SESSION['userIDs'] = $userIds;
            }

            echo '
            </tbody>
            </table>
            ';


            // Some information to display to the user
            $start = $offset + 1;
            $end = min(($offset + $limit), $total);

            // The "back" link
            $prevlink = ($page > 1) ? '<a class="page-item" href="?tab=' . $_SESSION['tab'] . '&page=1" title="First page">شروع</a> <a class="page-item" href="?tab=' . $_SESSION['tab'] . '&page=' . ($page - 1) . '" title="Previous page">قبلی</a>' : '<span class="disabled page-item">شروع</span> <span class="disabled page-item">قبلی</span>';

            // The "forward" link
            $nextlink = ($page < $pages) ? '<a class="page-item" href="?tab=' . $_SESSION['tab'] . '&page=' . ($page + 1) . '" title="Next page">بعدی</a> <a class="page-item" href="?tab=' . $_SESSION['tab'] . '&page=' . $pages . '" title="Last page">پایان</a>' : '<span class="disabled page-item">بعدی</span> <span class="disabled page-item">پایان</span>';


            //pagesinfo
            $pagesinfo = '<span class="pageinfo"> صفخه ' . $page . ' از ' . $pages . ' ، نمایش ' . $start . ' تا ' . $end . ' از ' . $total . ' نتیجه</span>';
            // Display the paging information
            echo '<div id="paging" class="admin-table-pagination"><p>', $prevlink, $pagesinfo, $nextlink, ' </p></div>';
        } else {
            echo '<p>متاسفانه نتیجه ای با این عبارت یافت نشد!</p>';
        }
    } catch (Exception $e) {
        echo '<p>', $e->getMessage(), '</$row>';
    }
}

function dropBoxSelect($pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM `apartment`");
    $stmt->execute();
    $apartments = $stmt->fetchAll();
    $i = 0;
    echo '
    <small class=" select-box-hint clr-muted">برای انتخاب چندتایی کلید ctrl را نگهدارید</small>
    
    <select class="select-box" name="selectlist[]" multiple size = 6>
    
    <option value="all" selected>همه واحد ها</option>
    ';

    var_dump($apartments);
    foreach ($apartments as $ap) {
        $stmt2 = $pdo->prepare("SELECT * FROM `account` WHERE `ac_apartment`=? ;");
        $stmt2->execute([$ap['ap_number']]);
        $lastname = $stmt2->fetch();
        $stmt3 = $pdo->prepare("SELECT * FROM `account` WHERE `ac_apartment`=? ;");
        $stmt3->execute([$ap['ap_number']]);
        $gender = $stmt3->fetch();
        $i += 1;
        if ($gender['ac_gender'] == '1') {
            $value = 'واحد ' . $i . ' - آقای ' . $lastname['ac_lastname'] . '';
        } elseif ($gender['ac_gender'] == '2') {
            $value = 'واحد ' . $i . ' - خانم ' . $lastname['ac_lastname'] . '';
        }
        echo '<option value="' . $i . '"> ' . $value . ' </option>';
    }

    echo '
    </select>
    ';
}

function create_zip($files = array(), $destination = '', $overwrite = true)
{
    //if the zip file already exists and overwrite is false, return false
    if (file_exists($destination) && !$overwrite) {
        return false;
    }
    //vars
    $valid_files = array();
    //if files were passed in...
    if (is_array($files)) {

        //cycle through each file
        foreach ($files as $file => $value) {
            //make sure the file exists
            if (file_exists($value)) {
                $valid_files[] = $value;
            }
        }
    }
    //if we have good files...
    if (count($valid_files)) {
        //create the archive
        $zip = new ZipArchive();
        if (file_exists($destination)) {
            $zip->open($destination, ZipArchive::OVERWRITE);
        } else {
            $zip->open($destination, ZipArchive::CREATE);
        }
        //add the files
        foreach ($valid_files as $file => $value) {
            $path = $value;
            $path_parts = pathinfo($path);
            $zip->addFile($value, $path_parts['basename']);
        }
        //debug
        //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;

        //close the zip -- done!
        $zip->close();

        //check to make sure the file exists
        return file_exists($destination);
    } else {
        return false;
    }
}

function backup_tables($DBH, $tables, $namebak)
{

    $DBH->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_NATURAL);

    //Script Variables
    $compression = false;
    $BACKUP_PATH = "../backup/";
    $nowtimename = time() . '-' . $namebak;
    $now = time();
    $fullbkpath = $BACKUP_PATH.$nowtimename.'.sql';

    //create/open files
    if ($compression) {
        $zp = gzopen($BACKUP_PATH . $nowtimename . '.sql.gz', "a9");
    } else {
        $handle = fopen($BACKUP_PATH . $nowtimename . '.sql', 'a+');
    }

    //array of all database field types which just take numbers
    $numtypes = array('tinyint', 'smallint', 'mediumint', 'int', 'bigint', 'float', 'double', 'decimal', 'real');

    //get all of the tables
    if (empty($tables)) {
        $pstm1 = $DBH->query('SHOW TABLES');
        while ($row = $pstm1->fetch(PDO::FETCH_NUM)) {
            $tables[] = $row[0];
        }
    } else {
        $tables = is_array($tables) ? $tables : explode(',', $tables);
    }

    //cycle through the table(s)

    foreach ($tables as $table) {
        $result = $DBH->query("SELECT * FROM $table");
        $num_fields = $result->columnCount();
        $num_rows = $result->rowCount();

        $return = "";
        //uncomment below if you want 'DROP TABLE IF EXISTS' displayed
        //$return.= 'DROP TABLE IF EXISTS `'.$table.'`;';

        //table structure
        $pstm2 = $DBH->query("SHOW CREATE TABLE $table");
        $row2 = $pstm2->fetch(PDO::FETCH_NUM);
        $ifnotexists = str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $row2[1]);
        $return .= "\n\n" . $ifnotexists . ";\n\n";

        if ($compression) {
            gzwrite($zp, $return);
        } else {
            fwrite($handle, $return);
        }
        $return = "";

        //insert values
        if ($num_rows) {
            $return = 'INSERT INTO `' . $table . '` (';
            $pstm3 = $DBH->query("SHOW COLUMNS FROM $table");
            $count = 0;
            $type = array();

            while ($rows = $pstm3->fetch(PDO::FETCH_NUM)) {
                if (stripos($rows[1], '(')) {
                    $type[$table][] = stristr($rows[1], '(', true);
                } else {
                    $type[$table][] = $rows[1];
                }

                $return .= "`" . $rows[0] . "`";
                $count++;
                if ($count < ($pstm3->rowCount())) {
                    $return .= ", ";
                }
            }

            $return .= ")" . ' VALUES';

            if ($compression) {
                gzwrite($zp, $return);
            } else {
                fwrite($handle, $return);
            }
            $return = "";
        }
        $count = 0;
        while ($row = $result->fetch(PDO::FETCH_NUM)) {
            $return = "\n\t(";

            for ($j = 0; $j < $num_fields; $j++) {

                //$row[$j] = preg_replace("\n","\\n",$row[$j]);

                if (isset($row[$j])) {

                    //if number, take away "". else leave as string
                    if ((in_array($type[$table][$j], $numtypes)) && (!empty($row[$j]))) {
                        $return .= $row[$j];
                    } else {
                        $return .= $DBH->quote($row[$j]);
                    }
                } else {
                    $return .= 'NULL';
                }
                if ($j < ($num_fields - 1)) {
                    $return .= ',';
                }
            }
            $count++;
            if ($count < ($result->rowCount())) {
                $return .= "),";
            } else {
                $return .= ");";
            }
            if ($compression) {
                gzwrite($zp, $return);
            } else {
                fwrite($handle, $return);
            }
            $return = "";
        }
        $return = "\n\n-- ------------------------------------------------ \n\n";
        if ($compression) {
            gzwrite($zp, $return);
        } else {
            fwrite($handle, $return);
        }
        $return = "";
    }

    $error1 = $pstm2->errorInfo();
    $error2 = $pstm3->errorInfo();
    $error3 = $result->errorInfo();
    echo $error1[2];
    echo $error2[2];
    echo $error3[2];

    if ($compression) {
        // readfile($BACKUP_PATH.'/'.$nowtimename.'.sql.gz');
        Header('Content-type: application/octet-stream');
        Header('Content-Disposition: attachment; filename=' . $nowtimename . '.sql.gz');
        gzclose($zp);
    } else {
        // readfile($BACKUP_PATH.'/'.$nowtimename.'.sql');
        // Header('Content-type: application/octet-stream');
        // Header('Content-Disposition: attachment; filename=' . $nowtimename . '.sql');

        fclose($handle);
        $pathdir = '../data/';
        // $files_to_zip = glob_recursive("../data/**/*.*");
        // array_push($files_to_zip, $BACKUP_PATH . $nowtimename . '.sql');
        //if true, good; if false, zip creation failed
        $zip_name = '../backup/BM-Backup-'.$now.'.zip';
        $path_parts = pathinfo($zip_name);
        $basename = $path_parts['basename'];
        // $result = create_zip($files_to_zip, $zip_name);
        // $result = Zip2($pathdir, $zip_name,true);
        $gza = new GoodZipArchive($pathdir,$zip_name,$fullbkpath) ;
        if ($gza) {
            header('Content-Type: application/zip');
            header('Content-disposition: attachment; filename='.$basename.'');
            header('Content-Length: ' . filesize($zip_name));
            readfile($zip_name);
            readfile($path_parts['filename'].'sql');
        }
    }
}

function glob_recursive($pattern, $flags = 0)
{
    $files = glob($pattern, $flags);
    foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir) {
        $files = array_merge($files, glob_recursive($dir . '/' . basename($pattern), $flags));
    }
    return $files;
}

