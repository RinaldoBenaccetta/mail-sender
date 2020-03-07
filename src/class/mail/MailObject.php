<?php


namespace Mail;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class MailObject {
  private   $debug;
  private   $encryptionMethod;
  protected $host;
  protected $port;
  protected $smtpAuthentication;
  protected $mailLogin;
  protected $mailPassword;
  protected $senderMail;
  protected $senderName;
  protected $replyMail;
  protected $replyName;
  protected $recipientMail;
  protected $recipientName;


  public function __construct($options) {
    $this->hydrate($options);
    //$this->send($options);
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
   * @return mixed
   */
  public function getReplyMail() {
    return $this->replyMail;
  }

  /**
   * @return mixed
   */
  public function getReplyName() {
    return $this->replyName;
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

  protected function getEncryptionMethod() {
    if ($this->encryptionMethod === 'STARTTLS') {
      return PHPMailer::ENCRYPTION_STARTTLS;
    } elseif ($this->encryptionMethod === 'SMTPS') {
      return PHPMailer::ENCRYPTION_SMTPS;
    }
  }

  protected function getDebug() {
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