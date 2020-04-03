<?php


namespace MailSender\controller;


use Exception;
use MailSender\data\Environment;
use MailSender\data\Post;
use MailSender\data\Server;
use MailSender\exception\EmailValidationException;
use MailSender\exception\ExceptionHandler;
use MailSender\exception\ForgottenOptionException;
use MailSender\exception\RenderException;
use MailSender\mail\MailOptions;
use MailSender\mail\MailSend;
use MailSender\mail\MailSettings;
use MailSender\response\ReturnSuccess;
use MailSender\settings\GetSettings;
use MailSender\settings\Settings;
use MailSender\tools\Log;
use MailSender\tools\Performance;
use MailSender\tools\StringTool;

class Process
{
    /**
     * Filter post class.
     *
     * @var Post
     */
    private POST $_post;

    /**
     * The settings of the app.
     *
     * @var object
     */
    private object $_settings;

    /**
     * Process constructor.
     *
     * @throws ForgottenOptionException
     */
    public function __construct()
    {
//        $this->logMemoryUsage();
        $this->setSettings();
        $this->setPost();
        $this->sendMail();
//        $this->logMemoryUsage();
        new Log('info', Performance::getAllocatedMemory("end allocated"));
        new Log('info', Performance::getUsageMemory("end usage"));
    }

//    protected function logMemoryUsage() {
//        $memoryUsage = Units::formatBytes(memory_get_usage(true), 1);
//        $memoryPeak = Units::formatBytes(memory_get_peak_usage(true), 1);
////        $memoryUsage = Units::formatBytes(999999999999999, 1);
////        $memoryPeak = Units::formatBytes(1000000, 1);
////        $memoryUsage = memory_get_usage();
////        $memoryPeak = memory_get_peak_usage();
//        $memoryMessage = "Memory usage : {$memoryUsage} | Memory Peak : {$memoryPeak}";
//        new Log('info', $memoryMessage);
//    }

    /**
     * Set the settings.
     */
    protected function setSettings(): void

    {
        $settingsClass = new Settings();
        $this->_settings = (new GetSettings($settingsClass))->getSettings();
    }

    /**
     * Set the post object.
     *
     * @throws ForgottenOptionException
     */
    protected function setPost(): void
    {
        $this->_post = new Post($_POST, $this->_settings);
    }

    /**
     * @return array
     * @return array
     * @throws Exception
     *
     * @throws RenderException
     */
    protected function prepareMail(): array
    {
        $environment = new Environment($this->_settings);
        $server = new Server($environment);
        //unset($environment); // change nothing
        gc_collect_cycles();
        $mailOptions = new MailOptions($this->_post, $this->_settings);
        $mailSettings = new MailSettings($server, $mailOptions);
        //unset($mailOptions); // change nothing
        gc_collect_cycles();
        return $mailSettings->getAll();
    }

    /**
     * Get the custom success page from post.
     *
     * @return string
     * @throws EmailValidationException
     */
    protected function getCustomSuccessPage(): string
    {
        if (property_exists($this->_post->getPost(), 'mailOk')) {
            return $this->_post->getPost()->mailOk;
        } else {
            return null;
        }
    }

    /**
     * Get the custom error page from $_POST.
     * Get the value directly by $_POST because Post class can throw exception
     * and return an un-valid value.
     *
     * @return string
     */
    protected function getCustomErrorPage(): string
    {
        if (isset($_POST['mailError'])) {
            return StringTool::toSanitizedString($_POST['mailError']);
        } else {
            return null;
        }
    }

    /**
     * Send the mail.
     */
    protected function sendMail(): void
    {
        try {
            // prepare mail
            $options = $this->prepareMail();
            // send the mail
            new MailSend($options);
            // return the response
            new ReturnSuccess($this->_settings, $this->getCustomSuccessPage());
        } catch (Exception $e) {
            new ExceptionHandler($this->_settings, $e, $this->getCustomErrorPage());
        } finally {
            // Add what would be executed even if an exception is throw
            // close all here
        }
    }

}
