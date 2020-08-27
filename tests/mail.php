<?php
     $to      = 'rouvilleq@gmail.com';
     $subject = 'le sujet';
     $message = 'Bonjour !';
     $headers = 'From: webmaster@example.com' . "\r\n" .
     'Reply-To: webmaster@example.com' . "\r\n" .
     'X-Mailer: PHP/' . phpversion();


$success = mail($to, $subject, $message, $headers);

if (!$success) {
    $errorMessage = error_get_last()['message'];
}

phpinfo();