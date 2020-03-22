<?php


namespace MailSender\mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Exception;

class MailObject
{


    /**
     * The hostname of the mail server.
     *
     * use
     * $mail->Host = gethostbyname('smtp.gmail.com');
     * if your network does not support SMTP over IPv6.
     *
     * @var string
     */
    protected string $host;
    /**
     * The SMTP port number - 587 for authenticated TLS,
     * a.k.a. RFC4409 SMTP submission.
     *
     * @var int
     */
    protected int $port;
    /**
     * Whether to use SMTP authentication.
     *
     * @var bool
     */
    protected bool $smtpAuthentication;
    /**
     * Username to use for SMTP authentication.
     * Use full email address for gmail.
     *
     * @var string
     */
    protected string $mailLogin;
    /**
     * Password to use for SMTP authentication.
     *
     * @var string
     */
    protected string $mailPassword;
    /**
     * E-mail the message is to be sent from.
     *
     * @var string
     */
    protected string $senderMail;
    /**
     * Name the message is to be sent to.
     *
     * @var string
     */
    protected string $senderName;
    /**
     * An alternative E-mail reply-to address.
     *
     * @var string
     */
    protected string $replyMail;
    /**
     * An alternative Name reply-to address.
     *
     * @var string
     */
    protected string $replyName;
    /**
     * E-mail the message is to be sent to.
     *
     * @var string
     */
    protected string $recipientMail;
    /**
     * Name the message is to be sent to.
     *
     * @var string
     */
    protected string $recipientName;
    /**
     * The mail subject.
     *
     * @var string
     */
    protected string $subject;
    /**
     * The body of the mail in HTML.
     *
     * @var string
     */
    protected string $htmlBody;
    /**
     * The Alternative of the HTML mail in plain text.
     *
     * @var string
     */
    protected string $altBody;
    /**
     * Debug mode.
     *
     * off = for production use
     * client  = client messages
     * server = client and server messages
     *
     * @var string
     */
    private string $debug;
    /**
     * The encryption mechanism to use - STARTTLS or SMTPS.
     *
     * STARTTLS or SMTPS.
     *
     * @var string
     */
    private string $encryptionMethod;

    public function __construct($options)
    {
        $this->hydrate($options);
    }

    /**
     * Hydrate an object.
     *
     * @param array $data
     */
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method) && !empty($value)) {
                $this->$method($value);
            }
        }
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param int $port
     */
    public function setPort(int $port): void
    {
        $this->port = $port;
    }

    /**
     * @return bool
     */
    public function getSmtpAuthentication()
    {
        return $this->smtpAuthentication;
    }

    /**
     * @param bool $smtpAuthentication
     */
    public function setSmtpAuthentication(bool $smtpAuthentication): void
    {
        $this->smtpAuthentication = $smtpAuthentication;
    }

    /**
     * @return string
     */
    public function getMailLogin()
    {
        return $this->mailLogin;
    }

    /**
     * @param string $mailLogin
     */
    public function setMailLogin(string $mailLogin): void
    {
        $this->mailLogin = $mailLogin;
    }

    /**
     * @return string
     */
    public function getMailPassword()
    {
        return $this->mailPassword;
    }

    /**
     * @param string $mailPassword
     */
    public function setMailPassword(string $mailPassword): void
    {
        $this->mailPassword = $mailPassword;
    }

    /**
     * Return the E-mail to reply-to.
     * If there is no E-mail to reply, this will return the sender E-mail.
     *
     * @return string
     */
    public function getReplyMail()
    {
        if (!empty($this->replyMail)) {
            return $this->replyMail;
        }
        return $this->getSenderMail();
    }

    /**
     * @param string $replyMail
     */
    public function setReplyMail(string $replyMail): void
    {
        $this->replyMail = $replyMail;
    }

    /**
     * @return string
     */
    public function getSenderMail()
    {
        return $this->senderMail;
    }

    /**
     * @param string $senderMail
     */
    public function setSenderMail(string $senderMail): void
    {
        $this->senderMail = $senderMail;
    }

    /**
     * Return the name to reply-to.
     * If there is no E-mail to reply, this will return the sender name.
     *
     * @return string
     */
    public function getReplyName()
    {
        if (!empty($this->replyName)) {
            return $this->replyName;
        }
        return $this->getSenderName();
    }

    /**
     * @param string $replyName
     */
    public function setReplyName(string $replyName): void
    {
        $this->replyName = $replyName;
    }

    /**
     * @return string
     */
    public function getSenderName()
    {
        return $this->senderName;
    }

    /**
     * @param string $senderName
     */
    public function setSenderName(string $senderName): void
    {
        $this->senderName = $senderName;
    }

    /**
     * @return string
     */
    public function getRecipientMail()
    {
        return $this->recipientMail;
    }

    /**
     * @param string $recipientMail
     */
    public function setRecipientMail(string $recipientMail): void
    {
        $this->recipientMail = $recipientMail;
    }

    /**
     * @return string
     */
    public function getRecipientName()
    {
        return $this->recipientName;
    }

    /**
     * @param string $recipientName
     */
    public function setRecipientName(string $recipientName): void
    {
        $this->recipientName = $recipientName;
    }

    /**
     * Return the corresponding phpmailer encryption method.
     * Default is NULL when no encryption method or wrong encryption.
     *
     * @return string
     */
    public function getEncryptionMethod()
    {
        if (!empty($this->encryptionMethod) && $this->encryptionMethod === 'STARTTLS') {
            return PHPMailer::ENCRYPTION_STARTTLS;
        } elseif (!empty($this->encryptionMethod) && $this->encryptionMethod === 'SMTPS') {
            return PHPMailer::ENCRYPTION_SMTPS;
        }
        return null;
    }

    /**
     * @param string $encryptionMethod
     *
     * @throws Exception
     */
    public function setEncryptionMethod(string $encryptionMethod): void
    {
        if ($encryptionMethod === 'STARTTLS' || $encryptionMethod === 'SMTPS') {
            $this->encryptionMethod = $encryptionMethod;
        } else {
            throw new Exception(
                'Encryption method should be STARTTLS or SMTPS : ' . $encryptionMethod . ' given.'
            );
        }
    }

    /**
     * Return the corresponding SMTP option.
     * Default is off.
     *
     * @return int
     */
    public function getDebug()
    {
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
     * @param string $debug
     */
    public function setDebug(string $debug): void
    {
        $this->debug = $debug;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * Return the alternative body.
     *
     * If no alternative body is found,
     * return the html body with stripped tags.
     *
     * @return string
     * @throws Exception
     */
    public function getAltBody()
    {
        if (!empty($this->altBody)) {
            return $this->altBody;
        }
        return htmlspecialchars(trim(strip_tags($this->getHtmlBody())));
    }

    /**
     * @param string $altBody
     */
    public function setAltBody(string $altBody): void
    {
        $this->altBody = $altBody;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getHtmlBody()
    {
        return $this->htmlBody;
    }

    /**
     * @param string $htmlBody
     */
    public function setHtmlBody(string $htmlBody): void
    {
        $this->htmlBody = $htmlBody;
    }

}