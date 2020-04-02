<?php


namespace MailSender\mail;

use MailSender\exception\SendingException;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailSend extends MailObject
{

    /**
     * MailSend constructor.
     * @param $options
     * @throws SendingException
     */
    public function __construct($options)
    {
        parent::__construct($options);
        $this->send();
    }

    /**
     * @throws SendingException
     */
    protected function send()
    {
        $mail = new PHPMailer(true);

        // https://stackoverflow.com/questions/2491475/phpmailer-character-encoding-issues
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        try {
            // Tell PHPMailer to use SMTP
            $mail->isSMTP();

            $mail->SMTPDebug = $this->getDebug();

            $mail->Host = $this->getHost();

            $mail->Port = $this->getPort();

            $mail->SMTPSecure = $this->getEncryptionMethod();

            $mail->SMTPAuth = $this->getSmtpAuthentication();

            $mail->Username = $this->getMailLogin();

            $mail->Password = $this->getMailPassword();

            $mail->setFrom($this->getSenderMail(), $this->getSenderName());

            $mail->addReplyTo($this->getReplyMail(), $this->getReplyName());

            $mail->addAddress(
                $this->getRecipientMail(),
                $this->getRecipientName()
            );

            // Set the subject line
            $mail->Subject = $this->getSubject();

            $mail->isHTML(true);

            // Read an HTML message body from an external file, convert referenced images to embedded,
            // convert HTML into a basic plain-text alternative body
            // $mail->msgHTML(file_get_contents('contents.html'), __DIR__);

            // the HTML mail.
            $mail->Body = $this->getHtmlBody();

            // Alternative to html mail.
            $mail->AltBody = $this->getAltBody();

            $mail->send();

            //echo 'Message sent!';
        } catch (Exception $e) {
            throw new SendingException($mail->ErrorInfo);
        }


//    if (!$mail->send()) {
//      echo 'Mailer Error: ' . $mail->ErrorInfo;
//    }
//    else {
//      echo 'Message sent!';
//      //Section 2: IMAP
//      //Uncomment these to save your message in the 'Sent Mail' folder.
//      #if (save_mail($mail)) {
//      #    echo "Message saved!";
//      #}
//    }

    }

    //Section 2: IMAP
    ////IMAP commands requires the PHP IMAP Extension, found at: https://php.net/manual/en/imap.setup.php
    ////Function to call which uses the PHP imap_*() functions to save messages: https://php.net/manual/en/book.imap.php
    ////You can use imap_getmailboxes($imapStream, '/imap/ssl', '*' ) to get a list of available folders or labels, this can
    ////be useful if you are trying to get this working on a non-Gmail IMAP server.
    //function save_mail($mail) {
    //  //You can change 'Sent Mail' to any other folder or tag
    //  $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';
    //
    //  //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
    //  $imapStream = imap_open($path, $mail->Username, $mail->Password);
    //
    //  $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
    //  imap_close($imapStream);
    //
    //  return $result;
    //}

}