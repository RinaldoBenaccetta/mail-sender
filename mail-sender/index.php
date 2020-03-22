<?php

use MailSender\data\Post;
use MailSender\data\Server;
use MailSender\mail\MailOptions;
use MailSender\mail\MailSend;
use MailSender\mail\MailSettings;
use MailSender\settings\GetSettings;

require './vendor/autoload.php';

//$test = new Server();
//dump($test->getServerSettings());

//dump($_POST);

$settings = GetSettings::getSettings();
$post = new Post($_POST);
$server = new Server();
$mailOptions = new MailOptions($_POST, $settings);
$mailSettings = new MailSettings(
    $post,
    $server,
    $mailOptions
);
$options = $mailSettings->getAll();

// send the mail
new MailSend($options);
