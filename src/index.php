<?php

use MailSender\mail\MailSettings;
use MailSender\mail\MailSend;
use MailSender\settings\Settings;
use MailSender\settings\GetSettings;
use MailSender\tools\Debug;

//use MailSender\render\Render;

require '../vendor/autoload.php';
require 'class/Autoloader.php';

// Call the autoloader
MailSender\Autoloader::register();

//phpinfo();

//$errors = "";

//if(empty($_POST['name'])  ||
//  empty($_POST['eMail']) ||
//  empty($_POST['message']) ||
//  empty($_POST['test']))
//{
//  $errors .= "\n Error: all fields are required";
//}



//$settings = GetSettings::getSettings();

//$settings = new GetSettings();
//$settings->getSettingsTest();
//$settings = $settings->getSettings();
//Debug::var_dump($settings);

//$test = GetSettings::getSettings();
//Debug::var_dump($test->global->debug);



//var_dump($settings->getSettings()->mailOptions['defaultTemplate']);

//$name = $_POST['name'];
//$email_address = $_POST['email'];
//$message = $_POST['message'];

//echo $name;
//echo $email_address;
//echo $message;
//var_dump($_POST);

$mailOptions = new MailSettings($_POST);

$options = [
  'host' => $mailOptions->getHost(),
  'port' => $mailOptions->getPort(),
  'encryptionMethod' => $mailOptions->getEncryption(),
  'smtpAuthentication' => $mailOptions->getSmtpAuthentication(),
  'mailLogin' => $mailOptions->getMailLogin(),
  'mailPassword' => $mailOptions->getMailPassword(),
  'senderMail' => $mailOptions->getSenderMail(),
  'senderName' => $mailOptions->getSenderName(),
  'replyMail' => $mailOptions->getReplyMAil(),
  'replyName' => $mailOptions->getReplyName(),
  'recipientMail' => $mailOptions->getRecipientMail(),
  'recipientName' => $mailOptions->getRecipientMail(),
  'debug' => $mailOptions->getDebug(),
  'subject' => $mailOptions->getSubject(),
  'htmlBody' => $mailOptions->getHtmlBody(),
  'altBody' => $mailOptions->getAltBody(),
];

//echo $options['replyName'];

//echo $message;

// send the mail
new MailSend($options);

////Enable SMTP debugging
//// SMTP::DEBUG_OFF = off (for production use)
//// SMTP::DEBUG_CLIENT = client messages
//// SMTP::DEBUG_SERVER = client and server messages
//$mail->SMTPDebug = debug();
//
////Set the hostname of the mail server
////$mail->Host = 'smtp.gmail.com';
//$mail->Host = MailOptions::getHost();
//// use
//// $mail->Host = gethostbyname('smtp.gmail.com');
//// if your network does not support SMTP over IPv6
//
////Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
//$mail->Port = MailOptions::getPort();
//
////Set the encryption mechanism to use - STARTTLS or SMTPS
////$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//$mail->SMTPSecure = smtpSecure();
//
////Whether to use SMTP authentication
//$mail->SMTPAuth = MailOptions::getSmtpAuthentication();
//
////Username to use for SMTP authentication - use full email address for gmail
//$mail->Username = MailOptions::getMailLogin();
//
////Password to use for SMTP authentication
//$mail->Password = MailOptions::getMailPassword();
//
////Set who the message is to be sent from
//$mail->setFrom(MailOptions::getSenderMAil(), MailOptions::getSenderName());
//
////Set an alternative reply-to address
//$mail->addReplyTo(MailOptions::getSenderMAil(), MailOptions::getSenderName());
//
////Set who the message is to be sent to
//$mail->addAddress(MailOptions::getRecipientMail(), MailOptions::getRecipientMail());
//
////Set the subject line
//$mail->Subject = 'PHPMailer GMail SMTP test';
//
////Read an HTML message body from an external file, convert referenced images to embedded,
////convert HTML into a basic plain-text alternative body
////$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
//$mail->Body = 'There is a great disturbance in the Force.';
//
////Replace the plain text body with one created manually
//$mail->AltBody = 'This is a plain-text message body';
//
////Attach an image file
////$mail->addAttachment('images/phpmailer_mini.png');
//
////send the message, check for errors
//if (!$mail->send()) {
//  echo 'Mailer Error: ' . $mail->ErrorInfo;
//}
//else {
//  echo 'Message sent!';
//  //Section 2: IMAP
//  //Uncomment these to save your message in the 'Sent Mail' folder.
//  #if (save_mail($mail)) {
//  #    echo "Message saved!";
//  #}
//}



