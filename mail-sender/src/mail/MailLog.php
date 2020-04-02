<?php


namespace MailSender\mail;

use MailSender\data\Environment;
use MailSender\tools\BoolTool;
use Monolog\Formatter\HtmlFormatter;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\WebProcessor;
use MonologPHPMailer\PHPMailerHandler;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class MailLog
{

    /**
     * The settings imported from Settings class.
     *
     * @var object
     */
    private object $_settings;

    /**
     * @var object
     */
    private object $_environment;

    /**
     * MailLog constructor.
     * @param $settings
     * @param $severity
     * @param $data
     */
    public function __construct($settings, $severity, $data)
    {
        $this->setSettings($settings);
        $this->setEnvironment();
        $this->handleLog($severity, $data);
    }

    /**
     * @param object $settings
     */
    protected function setSettings(object $settings): void
    {
        $this->_settings = (object)$settings;
    }

    /**
     * Get environment variables.
     */
    protected function setEnvironment() {
        $environment = new Environment($this->_settings);
        $this->_environment = (object) $environment->getEnvironment();
    }

    /**
     * @param $severity
     * @param $data
     */
    protected function handleLog($severity, $data) {
        if (!empty(BoolTool::toBool($this->_environment->MAIL_ALERT))) {
            $this->sendLogMail($severity, $data);
        }
    }

    protected function sendLogMail($severity, $data): void {

        $mail = new PHPMailer(true);
        $logger = new Logger('logger');

        $mail->isSMTP();
        $mail->SMTPDebug = SMTP::DEBUG_CLIENT;
        $mail->Host = $this->_environment->HOST;
        $mail->Port = $this->_environment->PORT;
        $mail->SMTPSecure = $this->_environment->ENCRYPTION;
        $mail->SMTPAuth = BoolTool::toBool($this->_environment->SMTP_AUTHENTICATION);
        $mail->Username = $this->_environment->MAIL_LOGIN;
        $mail->Password = $this->_environment->MAIL_PASSWORD;

        $mail->setFrom($this->_environment->MAIL_ALERT_SENDERMAIL, $this->_environment->MAIL_ALERT_SENDERNAME);
        $mail->addAddress($this->_environment->MAIL_ALERT_RECIPIENTMAIL, $this->_environment->MAIL_ALERT_RECIPIENTNAME);

        $mail->Subject = $severity;

        $logger->pushProcessor(new IntrospectionProcessor);
        $logger->pushProcessor(new MemoryUsageProcessor);
        $logger->pushProcessor(new WebProcessor);

        $handler = new PHPMailerHandler($mail);
        $handler->setFormatter(new HtmlFormatter);

        $logger->pushHandler($handler);

        $logger->error($data);
    }

}



