<?php
$title = "Dashboard";
include_once 'header.php';
include_once '../includes/getdata.inc.php';
include_once '../includes/admin2.inc.php';

$_SESSION['tab'] = (empty($_SESSION['tab'])) ? "report" : $_SESSION['tab'];
$_SESSION['ascdesc'] = (empty($_SESSION['ascdesc'])) ? "DESC" : $_SESSION['ascdesc'];
$_SESSION['search'] = (empty($_SESSION['search'])) ? "" : $_SESSION['search'];
$_SESSION['tabSort'] = (empty($_SESSION['tabSort'])) ? "date" : $_SESSION['tabSort'];
// var_dump($_SESSION['nothashedPass'])
?>
<?php
require_once '../includes/functions.inc.php';
if (empty($_SESSION['logged-in'])) {
    header("Location: login.php");
}
?>
<div class="container-admin">
    <header class="admin-header d-flex">
        <?php include_once "admin-profile-card.php"; ?>
        </li>
        <li class="selected"><a href="admin-dashboard.php">اطلاعات</a></li>
        <li><a href="admin-message.php">پیام ها</a></li>
        <!-- <li><a href="admin-setting.php">تنظیمات</a></li> -->
        <li>
            <button class="admin__item admin__item-logout button-danger"><a href="../includes/logout.inc.php">خروج</a></button>
        </li>
    </ul>
    </header>
    <div class="admin-body d-flex">
        <form class="admin-main d-column" action="../includes/admin.inc.php" method="POST" onkeydown="return event.key != 'Enter';"  enctype="multipart/form-data">
            <div class="main__top d-flex">
                <ul class="tab table-tab d-flex">
                    <li class="tablinks <?php if($_SESSION['tab'] == 'apartment'){echo 'activeTab';} ?>"><a href="?tab=apartment">واحد ها</a></li>
                    <li class="tablinks <?php if($_SESSION['tab'] == 'account'){echo 'activeTab';} ?>"><a href="?tab=account">حساب ها</a></li>
                    <li class="tablinks hidden <?php if($_SESSION['tab'] == 'add'){echo 'activeTab';} ?>"><a href="?tab=add"></a></li>
                    <li class="tablinks hidden <?php if($_SESSION['tab'] == 'profile'){echo 'activeTab';} ?>"><a href="?tab=profile"></a></li>
                    <li class="tablinks <?php if($_SESSION['tab'] == 'report'){echo 'activeTab';} ?>"><a href="?tab=report">گزارشات پرداخت</a></li>
                </ul>
                <button class="admin-add d-flex button-add noletterspace" type="submit" name="action" value="backup">
                    پشتیبان گیری
                    <span class="material-icons-round">
                    cloud_download
                    </span>
                </button>
                
                <ul class="tab table-tab2 d-flex">
                    <li>
                        <a href="?tab=add">
                            <button class="admin-add d-flex button-primary noletterspace" type="button">
                                اضافه کردن
                                <span class="material-icons-round">
                                    add
                                </span>
                            </button>
                        </a>
                    </li>
                    <li>
                        <button class="admin-update d-flex button-success noletterspace" type="submit" name="action" value="save">
                            ثبت اطلاعات
                            <span class="material-icons-round">
                            done
                            </span>
                        </button>
                    </li>
                    <li>
                        <button class="admin-delete d-flex button-danger noletterspace" type="submit" name="action" value="delete">
                            حذف اطلاعات
                            <span onclick="editor_delete()" class="material-icons-round">
                                delete_forever
                            </span>
                        </button>
                    </li>
                    <li>
                        <div id="mySeacrhInput2" class="d-flex">
                        <input type="text" name="searchData" id="mySeacrhInput3" onkeyup="myFunction()"
                        placeholder="جستجو کن ..." value="<?php echo (empty($_SESSION['search']))? "":$_SESSION['search'] ?>">
                        <button type="submit" class="button-search d-flex" name="action" value="search">
                            <span class="material-icons-round " style="color: black;">
                            search
                            </span>
                        <?php 
                            echo '
                            <a class="d-flex button-search-reset" href="?tab='.$_SESSION['tab'].'&sort='.$_SESSION['tabSort'].'&mode='.$_SESSION['ascdesc'].'&search=">
                                <span class="material-icons-round">
                                restart_alt
                                </span>
                            </a>
                            ';
                            ?>
                        </button>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="admin-tab-content">
                <div id="table-apartment" style="display: block;" class="admin-form-table">
                    <?php
                        if ($_SESSION['tab'] == 'apartment') {
                            apartmentTable($pdo,12);
                        }
                        elseif ($_SESSION['tab'] == 'account') {
                            accountTable($pdo,12,$_SESSION['tabSort'],$_SESSION['ascdesc']);
                        }
                        elseif ($_SESSION['tab'] == 'report') {
                            reportTable($pdo,12,$_SESSION['tabSort'],$_SESSION['ascdesc']);
                        }
                        elseif ($_SESSION['tab'] == 'add') {
                            echo '
                            
                            <div class= clr-muted d-flex" style="text-align:center; padding-bottom:1rem; font-weight:lighter">
                                بخش های ستاره دار نباید خالی باشند و بخش اضافه کردن واحد برای ایجاد واحد های ساختمان کاربرد دارد
                            </div>
                            <div class="adminAdd-body d-flex">
                                <div class="col-3 d-column">
                                    <div class="adminAdd-inp d-flex">
                                        <label class="adminAdd-label" for="name">نام*</label>
                                        <input class="adminAdd-input" placeholder="نام به فارسی" type="text" name="name">
                                    </div>
                                    <div class="adminAdd-inp d-flex">
                                        <label class="adminAdd-label" for="apartment">شماره واحد</label>
                                        <input class="adminAdd-input" placeholder="00" type="text" name="apartment">
                                    </div>
                                    <div class="adminAdd-inp d-flex">
                                        <label class="adminAdd-label" for="codemelli">کد ملی*</label>
                                        <input class="adminAdd-input" placeholder="جهت بازیابی رمز برای کاربر" type="text" name="codemelli">
                                    </div>
                                </div>
                                <div class="col-3 d-column">
                                    <div class="adminAdd-inp d-flex">
                                        <label class="adminAdd-label" for="lastname">نام خانوادگی*</label>
                                        <input class="adminAdd-input" placeholder="نام خانوادگی به فارسی" type="text" name="lastname">
                                    </div>
                                    <div class="adminAdd-inp d-flex">
                                        <label class="adminAdd-label" for="rent">مبلغ اجاره*</label>
                                        <input class="adminAdd-input" placeholder="00000" type="text" name="rent">
                                    </div>
                                    <div class="adminAdd-inp d-flex">
                                        <label class="adminAdd-label" for="status">وضعیت حساب</label>
                                        <select class="adminAdd-input adminAdd-input-select" name="status">
                                            <option value="1">فعال</option>
                                            <option selected value="0">غیر فعال</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3 d-column">
                                    <div class="adminAdd-inp d-flex">
                                        <label class="adminAdd-label" for="phone">شماره همراه*</label>
                                        <input class="adminAdd-input" placeholder="بدون صفر" type="text" name="phone">
                                    </div>
                                    <div class="adminAdd-inp d-flex">
                                        <label class="adminAdd-label" for="charge">مبلغ شارژ*</label>
                                        <input class="adminAdd-input" placeholder="00000" type="text" name="charge">
                                    </div>
                                    <div class="adminAdd-inp d-flex">
                                        <label class="adminAdd-label" for="add-apartment">اضافه کردن واحد</label>
                                        <input class="adminAdd-input" type="text" name="add-apartment" placeholder="تعداد واحد های ساختمان">
                                    </div>
                                </div>
                            </div>
                            ';
                        }
                        elseif ($_SESSION['tab'] == 'profile') {
                            include_once "../includes/updateAdmin.inc.php";
                        }
                    ?>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
include_once 'footer.php';
?>