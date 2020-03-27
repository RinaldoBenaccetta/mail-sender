<?php


namespace MailSender\response;


use MailSender\tools\Redirect;

/**
 * Class Success
 * Handle success of mail sending.
 *
 * @package MailSender\response
 */
class Success extends Response
{
    /**
     * Success constructor.
     *
     * @param $settings
     */
    public function __construct($settings)
    {
        parent::__construct($settings);
        $this->response();
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
                // If the request is from Javascript.
                $this->defaultSuccess();
                break;
            case null :
                // If the request is from HTML
                // Redirect the page to the URL of redirect->defaultMailOkPage
                // in Settings class.
                $this->redirectPage(
                    $this->_settings->redirect->defaultMailOkPage
                );
                break;
            default :
                // If the request is from another.
                $this->defaultSuccess();
        }
    }

    /**
     * The default success send back the value of
     * response->success in Settings class.
     */
    protected function defaultSuccess(): void
    {
        echo $this->_settings->response->success;
    }

}