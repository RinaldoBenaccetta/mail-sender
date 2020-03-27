<?php


namespace MailSender\response;


use MailSender\tools\Redirect;

/**
 * Class Success
 * Handle success of mail sending.
 *
 * @package MailSender\response
 */
class Success
{
    /**
     * @var object
     */
    private object $_settings;


    /**
     * Success constructor.
     *
     * @param $settings
     */
    public function __construct($settings)
    {
        $this->setSettings($settings);
        $this->response();
    }

    /**
     * @param object $settings
     */
    private function setSettings(object $settings): void
    {
        $this->_settings = $settings;
    }

    /**
     * Choose the sending response according to client variable
     * received in $_POST.
     * If client variable is not set, it will assume that is a
     * post received directly by an HTML form and redirect to
     * the success page
     * (the URL set in redirect->defaultMailOkPage) in Settings class.
     */
    protected function response()
    {
        $client = $this->client();

        switch ($client) {
            case 'js' :
                // if the request is from Javascript.
                $this->defaultSuccess();
                break;
            case NULL :
                // if the request is from HTML
                $this->redirectPage();
                break;
            default :
                // if the request is from another
                $this->defaultSuccess();
        }

    }

    /**
     * Check if client value in $_POST is set.
     *
     * @return mixed|null
     */
    protected function client() {
        if (!empty($_POST['client'])) {
            return $_POST['client'];
        }
        return NULL;
    }

    /**
     * Redirect the page to the URL of redirect->defaultMailOkPage
     * in Settings class.
     *
     * @return Redirect
     */
    protected function redirectPage() : Redirect {
        return new Redirect($this->_settings,
                            $this->_settings->redirect->defaultMailOkPage);
    }

    /**
     * The default success send back the value of
     * response->success in Settings class.
     */
    protected function defaultSuccess() : void {
        echo $this->_settings->response->success;
    }

}