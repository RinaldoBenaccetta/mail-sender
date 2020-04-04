<?php


namespace MailSender;


class Path
{

    const ROOT_PATH = __DIR__;
    const TEMPLATES = self::ROOT_PATH . '/./templates';
    const CLASS_ROOT = self::ROOT_PATH . '/./class';
    const MAIL = self::CLASS_ROOT . '/./mail';
    const RENDER = self::CLASS_ROOT . '/./render';
    const SETTINGS = self::CLASS_ROOT . '/./settings';
    const TOOLS = self::CLASS_ROOT . '/./tools';
    const PARENT_ROOT = '../' . self::ROOT_PATH;
}