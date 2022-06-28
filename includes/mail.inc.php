<?php
if (isset($_POST['submit'])) {
    $phone = $_POST['number'];
    $message = $_POST['text'];
    $to_email = 'my @ gmail.com';
    $subject = 'New Message From User of BM site';
    $messagetotal = 'This mail is sent using the PHP mail user: ' . $phone . 'has this problem:' . $message;
    $headers = 'From: noreply @ company. com';
    //check if the email address is invalid $secure_check
    $secure_check = sanitize_my_email($to_email);
    if ($secure_check == false) {
        echo "Invalid input";
    } else { //send email 
        mail($to_email, $subject, $messagetotal, $headers);
        echo "This email is sent using PHP Mail";
    }
}
function sanitize_my_email($field)
{
    $field = filter_var($field, FILTER_SANITIZE_EMAIL);
    if (filter_var($field, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}
