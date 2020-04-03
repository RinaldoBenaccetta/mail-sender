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
     *
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
    protected function setEnvironment()
    {
        $environment = new Environment($this->_settings);
        $this->_environment = $environment->getEnvironmentObject();
    }

    /**
     * @param $severity
     * @param $data
     */
    protected function handleLog($severity, $data)
    {
        if (!empty($this->_environment->mailAlert)) {
            $this->sendLogMail($severity, $data);
        }
    }

    protected function sendLogMail($severity, $data): void
    {
        $mail = new PHPMailer(true);
        $logger = new Logger('logger');

        $mail->isSMTP();
        $mail->SMTPDebug = SMTP::DEBUG_CLIENT;
        $mail->Host = $this->_environment->host;
        $mail->Port = $this->_environment->port;
        $mail->SMTPSecure = $this->_environment->encryption;
        $mail->SMTPAuth = BoolTool::toBool(
            $this->_environment->smtpAuthentication
        );
        $mail->Username = $this->_environment->mailLogin;
        $mail->Password = $this->_environment->mailPassword;

        $mail->setFrom(
            $this->_environment->mailAlertSenderMail,
            $this->_environment->mailAlertSenderName
        );
        $mail->addAddress(
            $this->_environment->mailAlertRecipientMail,
            $this->_environment->mailAlertRecipientName
        );

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



