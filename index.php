<?php

use MailSender\data\Post;
use MailSender\mail\MailSettings;
use MailSender\mail\MailSend;
use MailSender\settings\Settings;
use MailSender\settings\GetSettings;
use MailSender\tools\Debug;
use MailSender\Path;
use MailSender\data\Server;

//use MailSender\render\Render;

//require '../vendor/autoload.php';
require './vendor/autoload.php';
//require './src/class/Autoloader.php';
//
//// Call the autoloader
//MailSender\Autoloader::register();

$test = new Server();
//var_dump($test->getServerSettings());


//$post = new Post();
//$mailSettings = new MailSettings($post->getPost($_POST));
//
//
//$options = $mailSettings->getAll();

// send the mail
//new MailSend($options);




