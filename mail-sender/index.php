<?php

use MailSender\data\Environment;
use MailSender\data\Post;
use MailSender\data\Server;
use MailSender\exception\EmailValidationException;
use MailSender\exception\ExceptionHandler;
use MailSender\exception\ForgottenOptionException;
use MailSender\exception\RenderException;
use MailSender\exception\SendingException;
use MailSender\exception\SettingsException;
use MailSender\mail\MailOptions;
use MailSender\mail\MailSend;
use MailSender\mail\MailSettings;
use MailSender\settings\GetSettings;
use MailSender\settings\Settings;
use MailSender\tools\Log;
use MailSender\tools\Redirect;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use MailSender\response\ReturnSuccess;

require './vendor/autoload.php';

$settingsClass = new Settings();
$settings = (new GetSettings($settingsClass))->getSettings();

try {
    $environment = new Environment($settings);
    $post = new Post($_POST, $settings);
    $server = new Server($environment);
    $mailOptions = new MailOptions($post, $settings);
    $mailSettings = new MailSettings($server, $mailOptions);
    $options = $mailSettings->getAll();
    // send the mail
    new MailSend($options);
    if (property_exists($post->getPost(), 'mailOk')) {
        $successPage = $post->getPost()->mailOk;
    } else {
        $successPage = null;
    }
    new ReturnSuccess($settings, $successPage);
}
//catch (Exception $e) {
//    new ExceptionHandler($settings, $e);
//}

catch (RenderException $e) {
    new ExceptionHandler($settings, $e);
}
catch (EmailValidationException $e) {
    new ExceptionHandler($settings, $e);
}
catch (SendingException $e) {
    new ExceptionHandler($settings, $e);
}
catch (ForgottenOptionException $e) {
    new ExceptionHandler($settings, $e);
}
catch (Exception $e) {

    new ExceptionHandler($settings, $e);

}

finally {
    // add what would be executed even if an exception is throw
    // close all here
}

