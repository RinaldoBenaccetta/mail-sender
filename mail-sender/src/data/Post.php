<?php


namespace MailSender\data;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use Egulias\EmailValidator\Validation\SpoofCheckValidation;
use MailSender\exception\EmailValidationException;
use MailSender\exception\ForgottenOptionException;
use MailSender\tools\StringTool;


/**
 * Class Post
 * Filter provided $POST
 *
 * @package MailSender\data
 */
class Post implements PostInterface
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
     * The post array after sanitization and validation.
     *
     * @var object
     */
    private object $_postOutput;

    /**
     * Post constructor.
     *
     * @param array $post
     * @param object $settings
     * @throws ForgottenOptionException
     */
    public function __construct(array $post, object $settings)
    {
        $this->setSettings($settings);
        $this->setPost($post);
    }

    /**
     * @param object $settings
     */
    private function setSettings(object $settings): void
    {
        $this->_settings = $settings;
    }

    /**
     * @param array $post
     * @throws ForgottenOptionException
     */
    private function setPost(array $post): void
    {
        if (!empty($post)) {
            $this->_post = $post;
        } else {
            throw new ForgottenOptionException('POST error.', 5070);
        }
    }

    /**
     * Get the Post Values sanitized and validated.
     *
     * @return object
     * @throws EmailValidationException
     */
    public function getPost(): object
    {
        if (empty($this->_postOutput)) {
            $this->_postOutput = (object)$this->loopThrough($this->_post);
        }
        return $this->_postOutput;
    }

    /**
     * Loop through array if not empty and is array or object.
     * If not, return NULL.
     *
     * @param $data
     * @return array|null
     * @throws EmailValidationException
     */
    protected function loopThrough($data)
    {
        if ($this->isArrayOrObject($data) && !empty($data)) {
            return $this->processDataLoop($data);
        }
        return null;
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
     * Transform objects to array.
     * transform values to string.
     * Transform HTML specials characters to ascii and escape.
     * Validate E-mail strings.
     *
     * @param $data
     *
     * @return array
     * @throws EmailValidationException
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
                    $output[$key] = StringTool::toSanitizedString($value);
            }
        }
        return $output;
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
        return in_array($key, (array)$this->_settings->validation->isMail);
    }

    /**
     * Validate the mail address.
     *
     * @param string $key The key of the address string in the $POST.
     * @param string $mail
     *
     * @return string
     * @throws EmailValidationException
     */
    protected function validateMail(string $key, string $mail): string
    {
        $validator = new EmailValidator();

        $multipleValidations = $this->getMailValidationRules();

        if (!$validator->isValid($mail, $multipleValidations)) {
            throw new EmailValidationException($mail, $key);
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