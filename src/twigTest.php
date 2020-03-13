<?php

require '../vendor/autoload.php';

//$loader = new \Twig\Loader\ArrayLoader([
//  'index' => 'Hello {{ name }}!',
//]);


$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');

$twig = new \Twig\Environment($loader, [
  'debug' => TRUE,
  'cache' => FALSE, // no need of cache for mails : they are all differents.
]);

//echo $twig->render('index', ['name' => 'Toto']);
echo $twig->render('contact-default.twig', [
  'contact' => [
    'firstName' => 'Toto',
    'name' => 'Le Hero',
    'phone' => '123 / 52 63 63'
  ],
  'message' => 'Bonjour!'
]);