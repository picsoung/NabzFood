<?php
require_once "../../bin/php5/lib/php/Mail.php";
require_once "../../bin/php5/lib/php/Mail/mime.php";

$from = "nicolas.grenie@gmail.com";
//$to = $form_signup->get_cleaned_data('email_addr');
$to = $email_addr;
$subject = "[Site Message]";
$text= 'text version';
$encoding = "text/html; charset=\"utf-8\"";
$html = $message_mail;

$param['text_charset'] = 'utf-8';
$param['html_charset'] = 'utf-8';
$param['head_charset'] = 'utf-8';


$headers_mail  = 'MIME-Version: 1.0'                           ."\r\n";
$headers_mail .= 'Content-type: text/html; charset="utf-8"'      ."\r\n";
$headers_mail .= 'TO: '.$to."\r\n" ;
$headers_mail .= 'From: "Mon site" <contact@monsite.com>'      ."\r\n";

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
  'Content-Type' => "text/html; charset=\"utf-8\"\r\n");
  
$body=$mime->get($param);
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