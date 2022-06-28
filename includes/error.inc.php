<?php
if (isset($_GET['error'])) {
    # code...
    $error = $_GET['error'];
    if ($_GET['error'] == 'emptyinput') {
        # code...
        $message = 'لطفا تمامی بخش ها را پر کنید!';
        echo '<script>window.alert("' . $message . '")</script>';
    }
    if ($_GET['error'] == 'invalidfirst-name') {
        # code...
        $message = 'لطفا نام را به فارسی بنویسید!';
        echo '<script>alert("' . $message . '")</script>';
    }
    if ($_GET['error'] == 'invalidtext') {
        # code...
        $message = 'لطفا متن را به فارسی بنویسید!';
        echo '<script>alert("' . $message . '")</script>';
        echo ("<script type='text/javascript'>
            location.replace(\"/building-managment/php/user-message.php\");
            </script>");
    }
    if ($_GET['error'] == 'invalidlast-name') {
        # code...
        $message = 'لطفت نام خانوادگی را به فارسی بنویسید!';
        echo '<script>alert("' . $message . '")</script>';
    }
    if ($_GET['error'] == 'invalidpasword') {
        # code...
        $message = 'رمز عبور حداقل باید 6 حرف داشته باشد!';
        echo '<script>alert("' . $message . '")</script>';
    }
    if ($_GET['error'] == 'passwordsdontmatch') {
        # code...
        $message = 'تکرار رمز عبور اشتباه است!';
        echo '<script>alert("' . $message . '")</script>';
    }
    if ($_GET['error'] == 'invalidphone') {
        # code...
        $message = 'شماره همراه باید 10 عدد و بدون صفر باشد!';
        echo '<script>alert("' . $message . '")</script>';
    }
    if ($_GET['error'] == 'phonetaken') {
        # code...
        $message = 'شماره همراه قبلا در سیستم وجود دارد!';
        echo '<script>alert("' . $message . '")</script>';
    }
    if ($_GET['error'] == 'InvalidUsername') {
        # code...
        $message = 'با این شماره همراه اطلاعاتی در سیستم یافت نشد';
        echo '<script>alert("' . $message . '")</script>';
    }
    if ($_GET['error'] == 'wrongpassword') {
        # code...
        $message = 'رمز عبور اشتباه است!';
        echo '<script>alert("' . $message . '")</script>';
    }
    if ($_GET['error'] == 'none') {
        # code...
        $message = 'ثبت نام شما با موفقیت انجام شد!';
        echo '<script>alert("' . $message . '")</script>';
    }
    if ($_GET['error'] == 'systemerror') {
        # code...
        $message = 'دریافت اطلاعا از سیستم با خطا مواجه شد!';
        echo '<script>alert("' . $message . '")</script>';
    }
}

if (isset($_GET['user'])) {
    if ($_GET['user'] == 'failedsubmit') {
        # code...
        $message = 'متاسفانه ثبت اطلاعات ناموفق بود!';
        echo '<script>alert("' . $message . '")</script>';
    }
    if ($_GET['user'] == 'successsubmit') {
        # code...
        $message = 'ثبت اطلاعات با موفقیت انجام شد!';
        echo '<script>alert("' . $message . '")</script>';
        echo ("<script type='text/javascript'>
        location.replace(\"/building-managment/php/user-dashboard.php\");
        </script>");
    }
    if ($_GET['user'] == 'successfullread') {
        # code...
        $message = 'عملیات با موفقیت انجام شد!';
        echo '<script>alert("' . $message . '")</script>';
        echo ("<script type='text/javascript'>
        location.replace(\"/building-managment/php/user-message.php\");
        </script>");
    }
}

if (isset($_GET['admin'])) {
    if ($_GET['admin'] == 'failedsubmit') {
        # code...
        $message = 'متاسفانه ثبت اطلاعات ناموفق بود!';
        echo '<script>alert("' . $message . '")</script>';
    }
    if ($_GET['admin'] == 'searchnotfound') {
        # code...
        $message = 'نتیجه ای با این عبارت پیدا نشد!';
        echo '<script>alert("' . $message . '")</script>';
    }
    if ($_GET['admin'] == 'successsubmit') {
        # code...
        $message = 'ثبت اطلاعات با موفقیت انجام شد!';
        echo '<script>alert("' . $message . '")</script>';
        echo ("<script type='text/javascript'>
        location.replace(\"/building-managment/php/admin-dashboard.php\");
        </script>");
    }
    if ($_GET['admin'] == 'successdelete') {
        # code...
        $message = 'حذف اطلاعات با موفقیت انجام شد!';
        echo '<script>alert("' . $message . '")</script>';
        echo ("<script type='text/javascript'>
        location.replace(\"/building-managment/php/admin-dashboard.php\");
        </script>");
    }
    if ($_GET['admin'] == 'deletenotselect') {
        # code...
        $message = 'گزینه ای برای حذف انتخاب نکرده اید!';
        echo '<script>alert("' . $message . '")</script>';
        echo ("<script type='text/javascript'>
        location.replace(\"/building-managment/php/admin-dashboard.php\");
        </script>");
    }
    if ($_GET['admin'] == 'backupsuccess') {
        # code...
        $message = 'تهیه نسخه پشتیبان با موفقیت انجام شد!';
        echo '<script>alert("' . $message . '")</script>';
        echo ("<script type='text/javascript'>
        location.replace(\"/building-managment/php/admin-dashboard.php\");
        </script>");
    }
    if ($_GET['admin'] == 'emptystar') {
        # code...
        $message = 'لطفا بخش های ستاره دار را پر کنید!';
        echo '<script>alert("' . $message . '")</script>';
        echo ("<script type='text/javascript'>
        location.replace(\"/building-managment/php/admin-dashboard.php?tab=add\");
        </script>");
    }
    if ($_GET['admin'] == 'successcreateapartment') {
        # code...
        $message = 'واحد ها با موفقیت اضافه شدند!';
        echo '<script>alert("' . $message . '")</script>';
        echo ("<script type='text/javascript'>
        location.replace(\"/building-managment/php/admin-dashboard.php?tab=add\");
        </script>");
    }
    if ($_GET['admin'] == 'emptyAddall') {
        # code...
        $message = 'کادر ها خالی هستند!';
        echo '<script>alert("' . $message . '")</script>';
        echo ("<script type='text/javascript'>
        location.replace(\"/building-managment/php/admin-dashboard.php?tab=add\");
        </script>");
    }
}

if (isset($_GET['file'])) {

    $file = $_GET['file'];
    $path_parts = pathinfo($file);
    $file_dirname = $path_parts['dirname'];
    $file_basename = $path_parts['basename'];
    $file_name = $path_parts['filename'];
    $file_ext = $path_parts['extension'];


    if ($file_dirname =='messages') {
        $path = '../data/messages/'.$file_basename;header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.$file_basename.'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($path));
        readfile($path);
        exit;
    }
}
