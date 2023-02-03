<?php

// Emails are to be sent via postfix server
// Instructions to start one in macOS are in https://www.garron.me/en/mac/postfix-relay-gmail-mac-os-x-local-smtp.html
// But this does not work yet
// And you need it for Windows
// Ask the teacher!

if (isset($_POST["email"])){
    $email = $_POST["email"];
    $to = "reisbureau2023@gmail.com";
    $subject = "Contact form submission: $name";
    $body = "You have received a new message. ".
    " Here are the details:\n Name: $name \n".
    " Email: $email\n Message \n $message";
    $headers = "From: $myemail\n";
    $headers .= "Reply-To: $email";
    // the PhP mail function is used to send the email https://www.php.net/manual/en/function.mail.php
    mail($to, $subject, $body, $headers);
    // redirect to the 'thank you' page
    header('Location: contact-thank-you.php');
}
