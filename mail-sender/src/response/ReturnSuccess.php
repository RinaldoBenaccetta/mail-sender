<?php


namespace MailSender\response;


/**
 * Class Success
 * Handle success of mail sending.
 *
 * @package MailSender\response
 */
class ReturnSuccess extends Response
{
    /**
     * @var string|null
     */
    private ?string $_successPage;

    /**
     * Success constructor.
     * An ok page can be specified, it can be from custom settings or from
     * $post.
     *
     * @param             $settings
     * @param string|null $successPage
     */
    public function __construct($settings, string $successPage = null)
    {
        parent::__construct($settings);
        $this->setSuccessPage($successPage);
        $this->response();
    }

    /**
     * @param string|null $successPage
     */
    protected function setSuccessPage(string $successPage = null): void
    {
        if (!empty($successPage)) {
            $this->_successPage = $successPage;
        } elseif (!empty($this->_settings->redirect->defaultMailOkPage)) {
            $this->_successPage = $this->_settings->redirect->defaultMailOkPage;
        } else {
            $this->_successPage = null;
        }
    }

    /**
     * Choose the sending response according to client variable
     * received in $_POST.
     * If client variable is not set, it will assume that is a
     * post received directly by an HTML form and redirect to
     * the success page.
     * (the URL set in redirect->defaultMailOkPage) in Settings class.
     */
    protected function response()
    {
        $client = $this->client();

        switch ($client) {
            case 'js' :
                // If the request is from Javascript.
                $this->returnSuccessMessage();
                break;
            case null :
                // If the request is from HTML
                $this->returningWay();
                break;
            default :
                // If the request is from another.
                $this->returnSuccessMessage();
        }
    }

    /**
     * Evaluate the returning way.
     * if value redirect is set to true and there is an error page,
     * the page will be redirect. Otherwise an echo message will be sends.
     */
    protected function returningWay()
    {
        if ($this->isRedirected() && !empty($this->_successPage)) {
            $this->redirectPage($this->_successPage);
        } else {
            $this->returnSuccessMessage();
        }
    }

    /**
     * The default success send back the value of
     * response->success in Settings class.
     */
    protected function returnSuccessMessage(): void
    {
        echo $this->_settings->response->success;
    }

}