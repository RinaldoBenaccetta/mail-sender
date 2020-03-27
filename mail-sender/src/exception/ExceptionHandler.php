<?php


namespace MailSender\exception;


use MailSender\tools\Redirect;

class ExceptionHandler
{
    /**
     * The settings imported from Settings class.
     *
     * @var object
     */
    private object $_settings;

    /**
     * The error page.
     *
     * @var string
     */
    private string $_errorPage;

    public function __construct(object $settings, $exception, $errorPage =
    NULL )
    {
        $this->setSettings($settings);
        $this->setErrorPage($errorPage);
        $this->handle($exception);

    }

    /**
     * @param object $settings
     */
    protected function setSettings(object $settings): void {
        $this->_settings = (object) $settings;
    }

    /**
     * Define the error page.
     * If no page is provided, the default one set in the settings
     * will be used.
     * If that is not default error page in settings, null will be used.
     *
     * @param $errorPage
     */
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
            echo ('error');
            new Redirect($this->_settings, $this->_errorPage);
        } else {
            echo $exception->getMessage();
        }
    }
}