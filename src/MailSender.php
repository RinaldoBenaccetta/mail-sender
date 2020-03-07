<?php


/**
 * This example shows settings to use when sending via Google's Gmail servers.
 * This uses traditional id & password authentication - look at the gmail_xoauth.phps
 * example to see how to use XOAUTH2.
 * The IMAP section shows how to save this message to the 'Sent Mail' folder using IMAP commands.
 */

//Import PHPMailer classes into the global namespace
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;
use Mail\MailOptions;
use Mail\MailSend;

require '../vendor/autoload.php';
require 'class/Autoloader.php';
Autoloader::register();

//Create a new PHPMailer instance
//$mail = new PHPMailer;

//Tell PHPMailer to use SMTP
//$mail->isSMTP();

$options = [
  'host' => MailOptions::getHost(),
  'port' => MailOptions::getPort(),
  'encryption' => MailOptions::getEncryption(),
  'smtpAuthentication' => MailOptions::getSmtpAuthentication(),
  'mailLogin' => MailOptions::getMailLogin(),
  'mailPassword' => MailOptions::getMailPassword(),
  'senderMail' => MailOptions::getSenderMAil(),
  'senderName' => MailOptions::getSenderName(),
  'replyMail' => MailOptions::getReplyMAil(),
  'replyName' => MailOptions::getReplyName(),
  'recipientMail' => MailOptions::getRecipientMail(),
  'recipientName' => MailOptions::getRecipientMail(),
  'debug' => MailOptions::getDebug()
];

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



