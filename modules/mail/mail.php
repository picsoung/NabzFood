<?php
require_once "../../bin/php5/lib/php/Mail.php";
require_once "../../bin/php5/lib/php/Mail/mime.php";

$from = "nicolas.grenie@gmail.com";
$to = $form_signup->get_cleaned_data('email_addr');
$subject = "[Site Message]";
$text= 'text version';
$html = $message_mail;

$crlf="\n";

$host = "smtp.gmail.com";
$username = "nicolas.grenie";
$password = "jianguowai";
$port = "587";

$mime = new Mail_mime($crlf);
//$mime->setTXTbody($text);
$mime->setHTMLbody($html);

$headers = array ('From' => $from,
  'To' => $to,
  'Subject' => $subject,
  'Content-Type' => 'text/html; charset="UTF8"');
  
$body=$mime->get();
$headers = $mime->headers($headers);

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