<?php


namespace MailSender\data;

use Exception;
use MailSender\settings\GetSettings;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use Egulias\EmailValidator\Validation\SpoofCheckValidation;


/**
 * Class Post
 * Filter provided $POST
 *
 * @package MailSender\data
 */
class Post
{

    /**
     * The settings imported from Settings class.
     *
     * @var object
     */
    private object $_settings;

    /**
     * The post array before sanitization and validation.
     *
     * @var array
     */
    private array $_post;

    /**
     * Post constructor.
     *
     * @param array $post
     */
    public function __construct(array $post)
    {
        $this->setSettings();
        $this->setPost($post);
    }

    /**
     *
     */
    private function setSettings(): void
    {
        $this->_settings = GetSettings::getSettings();
    }

    /**
     * @param array $post
     */
    private function setPost(array $post): void
    {
        $this->_post = $post;
    }

    /**
     * Get the Post Values sanitized and validated.
     *
     * @return array|null
     * @throws Exception
     */
    public function getPost()
    {
        return $this->loopThrough($this->_post);
    }

    /**
     * Loop through array if not empty and is array or object.
     * If not, return NULL.
     *
     * @param $data
     * @return array|null
     * @throws Exception
     */
    protected function loopThrough($data)
    {
        if ($this->isArrayOrObject($data) && !empty($data)) {
            return $this->processDataLoop($data);
        }
        return null;
    }

    /**
     * Transform objects to array.
     * transform values to string.
     * Transform HTML specials characters to ascii and escape.
     * Validate E-mail strings.
     *
     * @param $data
     *
     * @return array
     * @throws Exception
     */
    protected function processDataLoop($data): array
    {
        $output = (array)[];
        foreach ($data as $key => $value) {
            switch ($value) {
                case $this->isArrayOrObject($value):
                    $output[$key] = $this->loopThrough($value);
                    break;
                case $this->isMailAddress($key):
                    $output[$key] = $this->validateMail($key, $value);
                    break;
                default :
                    $output[$key] = $this->toString($value);
            }
        }
        return $output;
    }

    /**
     * Check if provided value type is array or object.
     *
     * @param $value
     *
     * @return bool
     */
    protected function isArrayOrObject($value): bool
    {
        return is_array($value) || is_object($value);
    }

    /**
     * Check if the key is present in the isMail array in Settings.
     *
     * @param string $key
     *
     * @return bool
     */
    protected function isMailAddress(string $key)
    {
        return in_array($key, $this->_settings->validation->isMail);
    }


    /**
     * Transform HTML specials characters to ascii and escape the string.
     *
     * @param $string
     *
     * @return string
     */
    protected function toString($string): string
    {
        return addslashes(htmlspecialchars((string)$string));
    }

    /**
     * Validate the mail address.
     *
     * @param string $key The key of the address string in the $POST.
     * @param string $mail
     *
     * @return string
     * @throws Exception
     */
    protected function validateMail(string $key, string $mail): string
    {
        $validator = new EmailValidator();

        $multipleValidations = $this->getMailValidationRules();

        if (!$validator->isValid($mail, $multipleValidations)) {
            throw new Exception("value provided for {$key} is not valid.");
        }

        return $mail;
    }

    /**
     * Set the E-mail string validation rules according to
     * Settings.php in validation section.
     *
     * @return MultipleValidationWithAnd
     */
    protected function getMailValidationRules()
    {
        $validationList = [new RFCValidation()];
        if ($this->_settings->validation->DNSMailValidation) {
            $validationList[] = new DNSCheckValidation();
        }
        if ($this->_settings->validation->SpoofMailValidation) {
            $validationList[] = new SpoofCheckValidation();
        }
        return new MultipleValidationWithAnd($validationList);
    }

}