<?php


namespace MailSender\tools;


class Redirect
{
    /**
     * @var object
     */
    private object $_settings;

    /**
     * Redirect constructor.
     * @param $settings
     * @param $link
     */
    public function __construct($settings, $link)
    {
        $this->setSettings($settings);
        $this->redirect($link);
    }

    /**
     * @param $link
     */
    public function redirect($link): void {
        $link = $this->getRedirectLink($link);
        header("Location: {$link}");
        //die();// we can put a status code in die.
    }

    /**
     * @param $link
     * @return string
     */
    protected function getRedirectLink($link): string {
        return $this->getHTMLRootParent() . $link;
    }

    /**
     * @param object $_settings
     */
    protected function setSettings(object $_settings)
    {
        $this->_settings = $_settings;
    }

    /**
     * @return string
     */
    protected function getHTMLRootParent(): string
    {
        $repeat = $this->_settings->redirect->htmlRootParent;
        if ($repeat < 0) {
            $repeat = 0;
        }
        return str_repeat('../', $repeat);
    }

}