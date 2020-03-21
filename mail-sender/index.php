<?php

use MailSender\data\Post;
use MailSender\data\Server;
use MailSender\mail\MailSend;
use MailSender\mail\MailSettings;

require './vendor/autoload.php';

//$test = new Server();
//dump($test->getServerSettings());

//dump($_POST);


$post = new Post($_POST);
$server = new Server();
$mailSettings = new MailSettings(
    $post->getPost(),
    $server->getServerSettings()
);
$options = $mailSettings->getAll();

// send the mail
new MailSend($options);
