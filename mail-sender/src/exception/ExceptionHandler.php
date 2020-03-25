<?php


namespace MailSender\exception;


use MailSender\tools\Redirect;

class ExceptionHandler
{
    private object $_settings;

    private string $_errorPage;

    public function __construct(object $settings, $exception, $errorPage =
    NULL )
    {
        $this->setSettings($settings);
        $this->setErrorPage($errorPage);
        $this->handle($exception);

    }

    protected function setSettings(object $settings): void {
        $this->_settings = (object) $settings;
    }

    protected function setErrorPage($errorPage): void {
        if (!empty($errorPage)) {
            $this->_errorPage = $errorPage;
        } elseif(!empty($this->_settings->redirect->defaultMailErrorPage)) {
            $this->_errorPage =
                $this->_settings->redirect->defaultMailErrorPage;
        } else {
            $this->_errorPage = NULL;
        }
    }

    /**
     * @param object $exception
     */
    protected function handle($exception) {
        if (!empty($this->_errorPage)) {
            new Redirect($this->_settings, $this->_errorPage);
        } else {
            echo $exception->getMessage();
        }
    }
}