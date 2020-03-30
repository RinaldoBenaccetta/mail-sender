<?php

use MailSender\data\Environment;
use MailSender\data\Post;
use MailSender\data\Server;
use MailSender\exception\ExceptionHandler;
use MailSender\exception\RenderException;
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
use MailSender\response\Success;

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
    new Success($settings);
}
//catch (Exception $e) {
//    new ExceptionHandler($settings, $e);
//}
catch (SettingsException $e) {

    echo $e->getCode();
    echo $e->getMessage();

}
catch (RenderException $e) {
    echo $e->getCode();
    echo $e->getMessage();
}


finally {
    // add what would be executed even if an exception is throw
    // close all here
}

