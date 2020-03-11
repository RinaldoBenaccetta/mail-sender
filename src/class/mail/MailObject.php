<?php


namespace MailSender\mail;


//use mysql_xdevapi\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Exception;

class MailObject {


  /**
   * Debug mode.
   *
   * off = for production use
   * client  = client messages
   * server = client and server messages
   *
   * @var
   */
  private   $debug;

  /**
   * Set the encryption mechanism to use - STARTTLS or SMTPS.
   *
   * STARTTLS or SMTPS.
   *
   * @var
   */
  private   $encryptionMethod;

  /**
   * Set the hostname of the mail server.
   *
   * use
   * $mail->Host = gethostbyname('smtp.gmail.com');
   * if your network does not support SMTP over IPv6.
   *
   * @var
   */
  protected $host;

  /**
   * Set the SMTP port number - 587 for authenticated TLS,
   * a.k.a. RFC4409 SMTP submission.
   *
   * @var
   */
  protected $port;

  /**
   * Whether to use SMTP authentication.
   *
   * @var
   */
  protected $smtpAuthentication;

  /**
   * Username to use for SMTP authentication.
   * Use full email address for gmail.
   *
   * @var
   */
  protected $mailLogin;

  /**
   * Password to use for SMTP authentication.
   *
   * @var
   */
  protected $mailPassword;

  /**
   * Set E-mail the message is to be sent from.
   *
   * @var
   */
  protected $senderMail;

  /**
   * Set name the message is to be sent to.
   *
   * @var
   */
  protected $senderName;

  /**
   * Set an alternative E-mail reply-to address.
   *
   * @var
   */
  protected $replyMail;

  /**
   * Set an alternative Name reply-to address.
   *
   * @var
   */
  protected $replyName;

  /**
   * Set E-mail the message is to be sent to.
   *
   * @var
   */
  protected $recipientMail;

  /**
   * Set Name the message is to be sent to.
   *
   * @var
   */
  protected $recipientName;

  /**
   * Set the mail subject.
   *
   * @var
   */
  protected $subject;

  /**
   * The body of the mail in HTML.
   *
   * @var
   */
  protected $htmlBody;

  /**
   * The Alternative of the HTML mail in plain text.
   *
   * @var
   */
  protected $altBody;


  public function __construct($options) {
    $this->hydrate($options);
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
   *
   * @throws \Exception
   */
  public function setEncryptionMethod($encryptionMethod): void {
    if ($encryptionMethod === 'STARTTLS' || $encryptionMethod === 'SMTPS') {
      $this->encryptionMethod = $encryptionMethod;
    } else {
      throw new Exception('Encryption method should be STARTTLS or SMTPS : '. $encryptionMethod . ' given.');
    }

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

  /**
   * @param mixed $debug
   */
  public function setDebug($debug): void {
    $this->debug = $debug;
  }

  /**
   * @param mixed $subject
   */
  public function setSubject($subject): void {
    $this->subject = $subject;
  }

  /**
   * @param mixed $htmlBody
   */
  public function setHtmlBody($htmlBody): void {
    $this->htmlBody = $htmlBody;
  }

  /**
   * @param mixed $altBody
   */
  public function setAltBody($altBody): void {
    $this->altBody = $altBody;
  }

  /**
   * @return mixed
   */
  public function getHost() {
    return $this->host;
  }

  /**
   * @return mixed
   */
  public function getPort() {
    return $this->port;
  }

  /**
   * @return mixed
   */
  public function getSmtpAuthentication() {
    return $this->smtpAuthentication;
  }

  /**
   * @return mixed
   */
  public function getMailLogin() {
    return $this->mailLogin;
  }

  /**
   * @return mixed
   */
  public function getMailPassword() {
    return $this->mailPassword;
  }

  /**
   * @return mixed
   */
  public function getSenderMail() {
    return $this->senderMail;
  }

  /**
   * @return mixed
   */
  public function getSenderName() {
    return $this->senderName;
  }

  /**
   * Return the E-mail to reply-to.
   * If there is no E-mail to reply, this will return the sender E-mail.
   *
   * @return mixed
   */
  public function getReplyMail() {
    if (!is_null($this->replyMail)) {
      return $this->replyMail;
    }
    return $this->getSenderMail();
  }

  /**
   * Return the name to reply-to.
   * If there is no E-mail to reply, this will return the sender name.
   *
   * @return mixed
   */
  public function getReplyName() {
    if (!is_null($this->replyName)) {
      return $this->replyName;
    }
    return $this->getSenderName();
  }

  /**
   * @return mixed
   */
  public function getRecipientMail() {
    return $this->recipientMail;
  }

  /**
   * @return mixed
   */
  public function getRecipientName() {
    return $this->recipientName;
  }

  /**
   * Return the corresponding phpmailer encryption method.
   *
   * @return string
   */
  public function getEncryptionMethod() {
    if ($this->encryptionMethod === 'STARTTLS') {
      return PHPMailer::ENCRYPTION_STARTTLS;
    } elseif ($this->encryptionMethod === 'SMTPS') {
      return PHPMailer::ENCRYPTION_SMTPS;
    }
  }

  /**
   * Return the corresponding SMTP option.
   *
   * @return int
   */
  public function getDebug() {
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

  /**
   * @return mixed
   */
  public function getSubject() {
    return $this->subject;
  }

  /**
   * @return mixed
   * @throws \Exception
   */
  public function getHtmlBody() {
    return $this->htmlBody;
//    if (!is_null($this->htmlBody)) {
//      return $this->htmlBody;
//    }else {
//      throw new Exception('No HTML Body found.');
//    }
  }

  /**
   * Return the alternative body.
   *
   * If no alternative body is found,
   * return the html body with stripped tags.
   *
   * @return mixed
   */
  public function getAltBody() {
    if (!is_null($this->altBody)) {
      return $this->altBody;
    }
    return htmlspecialchars(trim(strip_tags($this->htmlBody)));
  }

}