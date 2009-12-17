<?php
require_once "../../../../../bin/php5/lib/php/Mail.php";

$from = "nicolas.grenie@gmail.com";
$to = $form_signup->get_cleaned_data('email_addr');
$subject = "[Site Message]";
$body = $message_mail;

$host = "smtp.gmail.com";
$username = "nicolas.grenie";
$password = "jianguowai";
$port = "587";

$headers = array ('From' => $from,
  'To' => $to,
  'Subject' => $subject);
$smtp = Mail::factory('smtp',
  array ('host' => $host,
      'port' => $port,
    'auth' => true,
    'username' => $username,
    'password' => $password));

$mail = $smtp->send($to, $headers, $body);

if (PEAR::isError($mail)) {
  echo("<p>" . $mail->getMessage() . "</p>");
 } else {
  echo("<p>Message successfully sent!</p>");
 }
?>