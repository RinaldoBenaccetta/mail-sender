<?php


namespace Mail;

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


class MailSend {

  private $debug;
  private $host;
  private $port;
  private $encryptionMethod;
  private $smtpAuthentication;
  private $mailLogin;
  private $mailPassword;
  private $senderMail;
  private $senderName;
  private $replyMail;
  private $replyName;
  private $recipientMail;
  private $recipientName;


  public function __construct($options) {
    $this->hydrate($options);
    $this->send($options);
  }

  /**
   * Hydrate an object.
   * To use inside the target object.
   * @param array $data
   */
  public function hydrate(array $data) {
    foreach ($data as $key => $value) {
      $method = 'set'.ucfirst($key);
      if (method_exists($this, $method)) {
        $this->$method($value);
      }
    }
  }

  /**
   * @param mixed $host
   */
  public function setHost($host): void {
    $this->host = $host;
  }

  /**
   * @param mixed $port
   */
  public function setPort($port): void {
    $this->port = $port;
  }

  /**
   * @param mixed $encryptionMethod
   */
  public function setEncryptionMethod($encryptionMethod): void {
    $this->encryptionMethod = $encryptionMethod;
  }

  /**
   * @param mixed $smtpAuthentication
   */
  public function setSmtpAuthentication($smtpAuthentication): void {
    $this->smtpAuthentication = $smtpAuthentication;
  }

  /**
   * @param mixed $mailLogin
   */
  public function setMailLogin($mailLogin): void {
    $this->mailLogin = $mailLogin;
  }

  /**
   * @param mixed $mailPassword
   */
  public function setMailPassword($mailPassword): void {
    $this->mailPassword = $mailPassword;
  }

  /**
   * @param mixed $senderMail
   */
  public function setSenderMail($senderMail): void {
    $this->senderMail = $senderMail;
  }

  /**
   * @param mixed $senderName
   */
  public function setSenderName($senderName): void {
    $this->senderName = $senderName;
  }

  /**
   * @param mixed $replyMail
   */
  public function setReplyMail($replyMail): void {
    $this->replyMail = $replyMail;
  }

  /**
   * @param mixed $replyName
   */
  public function setReplyName($replyName): void {
    $this->replyName = $replyName;
  }

  /**
   * @param mixed $recipientMail
   */
  public function setRecipientMail($recipientMail): void {
    $this->recipientMail = $recipientMail;
  }

  /**
   * @param mixed $recipientName
   */
  public function setRecipientName($recipientName): void {
    $this->recipientName = $recipientName;
  }

  private function send($options) {
    $mail = new PHPMailer;

    //Tell PHPMailer to use SMTP
    $mail->isSMTP();

    //Enable SMTP debugging
    // SMTP::DEBUG_OFF = off (for production use)
    // SMTP::DEBUG_CLIENT = client messages
    // SMTP::DEBUG_SERVER = client and server messages
    $mail->SMTPDebug = $this->debug();

    //Set the hostname of the mail server
    //$mail->Host = 'smtp.gmail.com';
    $mail->Host = $this->host;
    // use
    // $mail->Host = gethostbyname('smtp.gmail.com');
    // if your network does not support SMTP over IPv6

    //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = $this->port;

    //Set the encryption mechanism to use - STARTTLS or SMTPS
    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPSecure = $this->smtpSecure();

    //Whether to use SMTP authentication
    $mail->SMTPAuth = $this->smtpAuthentication;

    //Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = $this->mailLogin;

    //Password to use for SMTP authentication
    $mail->Password = $this->mailPassword;

    //Set who the message is to be sent from
    $mail->setFrom($this->senderMail, $this->senderName);

    //Set an alternative reply-to address
    $mail->addReplyTo($this->replyMail, $this->replyName);

    //Set who the message is to be sent to
    $mail->addAddress($this->recipientMail, $this->recipientName);

    //Set the subject line
    $mail->Subject = 'PHPMailer GMail SMTP test';

    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    //$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
    $mail->Body = 'There is a great disturbance in the Force.';

    //Replace the plain text body with one created manually
    $mail->AltBody = 'This is a plain-text message body';

    if (!$mail->send()) {
      echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
    else {
      echo 'Message sent!';
      //Section 2: IMAP
      //Uncomment these to save your message in the 'Sent Mail' folder.
      #if (save_mail($mail)) {
      #    echo "Message saved!";
      #}
    }

  }

  private function smtpSecure() {
    if ($this->encryptionMethod === 'STARTTLS') {
      return PHPMailer::ENCRYPTION_STARTTLS;
    } elseif ($this->encryptionMethod === 'SMTPS') {
      return PHPMailer::ENCRYPTION_SMTPS;
    }
  }

  private function debug() {
    switch ($this->debug) {
      case 'off' :
        return SMTP::DEBUG_OFF;
        break;
      case 'client' :
        return SMTP::DEBUG_CLIENT;
        break;
      case 'server' :
        return SMTP::DEBUG_SERVER;
        break;
      default :
        return SMTP::DEBUG_OFF;
    }
  }

}