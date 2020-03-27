<?php


namespace MailSender\response;


class Error extends Response
{
    /**
     * The URL of the error page.
     *
     * @var string
     */
    private string $_errorPage;

    /**
     * Error constructor.
     *
     * @param $settings
     * @param $errorPage
     */
    public function __construct($settings, $errorPage)
    {
        parent::__construct($settings);
        $this->setErrorPage($errorPage);
        $this->response();
    }

    /**
     * @param $errorPage
     */
    protected function setErrorPage($errorPage) {
        $this->_errorPage = $errorPage;
    }

    protected function response()
    {
        $client = $this->client();

        switch ($client) {
            case 'js' :

                // If the request is from Javascript.
                $this->defaultError();
                break;
            case NULL :
                // If the request is from HTML
                // Redirect the page to the URL of _errorPage.
                $this->redirectPage($this->_errorPage);
                break;
            default :
                // If the request is from another.
                $this->defaultError();
        }

    }

    /**
     * The default error send back the value of
     * response->error in Settings class.
     */
    protected function defaultError() : void {
        echo $this->_settings->response->error;
    }

}