<?php

require_once '../php/conn.php';
require_once 'jdf.php';


echo '
<div class="adminAdd-body d-flex">
    <div class="col-3 d-column">
        <div class="adminAdd-inp d-flex">
            <label class="adminAdd-label" for="pname">نام</label>
            <input class="adminAdd-input" placeholder="نام به فارسی" type="text" name="pname" value="'.$_SESSION['ufirstname'].'">
        </div>
        <div class="adminAdd-inp d-flex">
            <label class="adminAdd-label" for="pcodemelli">کد ملی</label>
            <input class="adminAdd-input" placeholder="جهت بازیابی رمز برای کاربر" type="text" name="pcodemelli" value="'.$_SESSION['uid'].'">
        </div>
        
        <div class="adminAdd-inp d-flex">
            <label class="adminAdd-label" for="puprofile">پروفایل</label>
            <div class="file-upload-3">
                <div class="button-wrapper">
                    <span class="label">
                        انتخاب فایل
                    </span>
                    <input type="file" name="puprofile" id="upload" class="upload-box"
                        placeholder="Upload File">
                </div>
            </div>
        </div>
    </div>
    <div class="col-3 d-column">
        <div class="adminAdd-inp d-flex">
            <label class="adminAdd-label" for="plastname">نام خانوادگی</label>
            <input class="adminAdd-input" placeholder="نام خانوادگی به فارسی" type="text" name="plastname" value="'.$_SESSION['ulastname'].'">
        </div>
        <div class="adminAdd-inp d-flex">
            <label class="adminAdd-label" for="charge">رمز عبور</label>
            <input class="adminAdd-input" placeholder="@#$qwe123" type="password" name="password" value="">
        </div>
    </div>
    <div class="col-3 d-column">
        <div class="adminAdd-inp d-flex">
            <label class="adminAdd-label" for="phone">شماره همراه</label>
            <input class="adminAdd-input" placeholder="بدون صفر" type="text" name="pphone" value="'.$_SESSION['uphone'].'">
        </div>
        <div class="adminAdd-inp d-flex">
            <label class="adminAdd-label" for="charge">تکرار رمز عبور</label>
            <input class="adminAdd-input" placeholder="@#$qwe123" type="password" name="password-repeat" value="">
        </div>

        <div class="adminAdd-inp d-flex">
            <input class="adminAdd-input" placeholder="@#$qwe123" type="hidden" name="age" value="'.$_SESSION['uage'].'">
        </div>

        <div class="adminAdd-inp d-flex">
            <input class="adminAdd-input" placeholder="@#$qwe123" type="hidden" name="gender" value="'.$_SESSION['ugender'].'">
        </div>
        
        <div class="adminAdd-inp d-flex">
            <input class="adminAdd-input" placeholder="@#$qwe123" type="hidden" name="apartment-id" value="'.$_SESSION['uapartment'].'">
        </div>
    </div>
</div>
';