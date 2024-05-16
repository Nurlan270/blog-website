<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sendEmail'])) {
    $email = $_SESSION['email'] ?? $_POST['email'];
    $msg = $_POST['message'];

    $to = "alexpython679@gmail.com";
    $subject = "=?utf-8?B?" . base64_encode("New incoming message.") . "?=";
    $headers = array(
        "From: $email",
        "Reply-To: $email",
        "X-Mailer: PHP/" . PHP_VERSION
    );
    $headers = implode("\r\n", $headers);

    if (mail($to, $subject, $msg, $headers)): echo 'SUCESS';
    else: echo 'FAIL';
    endif;
}