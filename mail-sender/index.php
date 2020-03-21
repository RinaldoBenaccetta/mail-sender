<?php

use MailSender\data\Post;
use MailSender\data\Server;
use MailSender\mail\MailSend;
use MailSender\mail\MailSettings;

require './vendor/autoload.php';

//$test = new Server();
//dump($test->getServerSettings());


$post = new Post();
$server = new Server();
$mailSettings = new MailSettings($post->getPost($_POST), $server->getServerSettings());
$options = $mailSettings->getAll();

// send the mail
new MailSend($options);




