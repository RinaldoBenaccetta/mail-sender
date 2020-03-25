<?php

use MailSender\data\Environment;
use MailSender\data\Post;
use MailSender\data\Server;
use MailSender\exception\ExceptionHandler;
use MailSender\mail\MailOptions;
use MailSender\mail\MailSend;
use MailSender\mail\MailSettings;
use MailSender\settings\GetSettings;
use MailSender\settings\Settings;
use MailSender\tools\Redirect;

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
    new Redirect($settings, $settings->redirect->defaultMailOkPage);
} catch (Exception $e) {
    new ExceptionHandler($settings, $e);
}

