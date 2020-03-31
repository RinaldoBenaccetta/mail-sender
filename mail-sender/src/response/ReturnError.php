<?php


namespace MailSender\response;


class ReturnError extends Response
{
    /**
     * code returned when no code is provided.
     */
    private const UNDETERMINED_CODE = 9000;

    /**
     * The URL of the error page.
     *
     * @var string
     */
    private ?string $_errorPage;

    /**
     * The code of the error.
     *
     * @var int
     */
    private ?int $_code;

    /**
     * Error constructor.
     *
     * @param $settings
     * @param $errorPage
     * @param $code
     */
    public function __construct(
        $settings,
        string $errorPage = null,
        int $code = null
    ) {
        parent::__construct($settings);
        $this->setErrorPage($errorPage);
        $this->setCode($code);
        $this->response();
    }

    /**
     * @param int $code
     */
    protected function setCode(int $code = null): void
    {
        if (!empty($code)) {
            $this->_code = $code;
        } else {
            $this->_code = self::UNDETERMINED_CODE;
        }
    }

    /**
     * @param string $errorPage
     */
    protected function setErrorPage(string $errorPage = null): void
    {
        $this->_errorPage = $errorPage;
    }

    protected function response()
    {
        $client = $this->client();

        switch ($client) {
            case 'js' :

                // If the request is from Javascript.
                $this->returnErrorMessage();
                break;
            case null :
                // If the request is from HTML
                // If there is a page.
                if (!empty($this->_errorPage)) {
                    // Redirect the page to the URL of _errorPage.
                    $this->redirectPage($this->_errorPage);
                } else {
                    // return the message.
                    $this->returnErrorMessage();
                }

                break;
            default :
                // If the request is from another.
                $this->returnErrorMessage();
        }
    }

    /**
     * The default error send back the value of
     * response->error in Settings class.
     *
     * @return string
     */
    protected function getErrorFlag(): string
    {
        return $this->_settings->response->error;
    }

    /**
     * Return the formatted response.
     *
     * @return void
     */
    protected function returnErrorMessage(): void
    {
        echo $this->getErrorFlag() . ':' . $this->_code;
    }

}