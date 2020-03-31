<?php


namespace MailSender\exception;


use MailSender\response\ReturnError;
use MailSender\tools\Log;

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
    private ?string $_errorPage;

    /**
     * ExceptionHandler constructor.
     * An error page can be specified, it can be from custom settings or from
     * $post. The custom settings must be a better solution : it is recovered
     * at start of the app. And the $post process can trow exception itself.
     *
     * @param object $settings
     * @param $exception
     * @param string $errorPage An error page can be passed as argument.
     */
    public function __construct(
        object $settings,
        $exception,
        string $errorPage =
        null
    ) {
        $this->setSettings($settings);
        $this->setErrorPage($errorPage);
        $this->handle($exception);
    }

    /**
     * @param object $settings
     */
    protected function setSettings(object $settings): void
    {
        $this->_settings = (object)$settings;
    }

    /**
     * Define the error page.
     * If no page is provided, the default one set in the settings
     * will be used.
     * If that is not default error page in settings, null will be used.
     *
     * @param $errorPage
     */
    protected function setErrorPage(string $errorPage = null): void
    {
        if (!empty($errorPage)) {
            $this->_errorPage = $errorPage;
        } elseif (!empty($this->_settings->redirect->defaultMailErrorPage)) {
            $this->_errorPage =
                $this->_settings->redirect->defaultMailErrorPage;
        } else {
            $this->_errorPage = null;
        }
    }

    /**
     * Return the error and log it.
     *
     * @param object $exception
     */
    protected function handle(object $exception)
    {
        new ReturnError(
            $this->_settings,
            $this->_errorPage,
            $exception->getCode()
        );
        $this->logException($exception);
    }

    /**
     * Log the exception.
     *
     * @param object $exception
     */
    protected function logException(object $exception): void
    {
        $severity = $this->getSeverity($exception->getCode());
        new Log($severity, $exception->getMessage());
    }

    /**
     * Get the severity of the exception according to the provided code.
     * list of severity :
     * https://github.com/Seldaek/monolog/blob/master/doc/01-usage.md#leveraging-channels
     *
     * @param $code
     * @return string
     */
    protected function getSeverity($code): string
    {
        switch ($code) {
            case 5000 :
            case 5010 :
            case 5020 :
            case 5030 :
            case 5040 :
            case 5050 :
            case 5060 :
                return 'warning';
                break;
            case 2000 :
                return 'error';
                break;
            case 4000:
            case 1000 :
                return 'critical';
                break;
            default : // code 3000 is handled here.
                return 'notice';
                break;
        }
    }
}