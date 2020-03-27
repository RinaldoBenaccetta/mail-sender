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
use MailSender\tools\Log;
use MailSender\tools\Redirect;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use MailSender\response\Success;

require './vendor/autoload.php';

$settingsClass = new Settings();
$settings = (new GetSettings($settingsClass))->getSettings();

//dump($_REQUEST); // $_POST = $_REQUEST
//dump($_POST); // $_POST = $_REQUEST

//dump(json_encode($_REQUEST));
//$logger = new Log(json_encode($_POST));
//print_r($_POST);
////$logger->info($_POST);
//$logger->warning('Adding a new user', (string)['username' => 'Seldaek']);

try {
    $environment = new Environment($settings);
    $post = new Post($_POST, $settings);
    $server = new Server($environment);
    $mailOptions = new MailOptions($post, $settings);
    $mailSettings = new MailSettings($server, $mailOptions);
    $options = $mailSettings->getAll();
    // send the mail
    new MailSend($options);
    // todo : use post option for ok redirection if exist
    new Success($settings);

    //echo json_encode('mail sended');
    //new Redirect($settings, $settings->redirect->defaultMailOkPage);
} catch (Exception $e) {
    //echo ('error');
    new ExceptionHandler($settings, $e);
}

