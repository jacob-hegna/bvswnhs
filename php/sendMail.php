<?php
require('Mail.php');
require_once('config.php');

function sendMail($to, $subject, $message) {
    // Configure the mailer mechanism
    $smtp = Mail::factory("smtp",
      array(
        "host"     => EMAIL_SERVER,
        "username" => EMAIL_USER,
        "password" => EMAIL_PASS,
        "auth"     => true,
        "port"     => EMAIL_PORT
      )
    );

    $headers = array(
      "From"    => EMAIL_USER,
      "To"      => $to,
      "Subject" => $subject
    );

    $mail = $smtp->send($to, $headers, $msg);
}
?>
