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
     * Post constructor.
     */
    public function __construct()
    {
        $this->setSettings();
    }

    /**
     *
     */
    public function setSettings(): void
    {
        $this->_settings = GetSettings::getSettings();
    }

    /**
     * Get the Post Values sanitized and validated.
     *
     * @param $post
     *
     * @return array|null
     * @throws \Exception
     */
    public function getPost($post)
    {
        if ($this->isArrayOrObject($post) && !empty($post)) {
            return $this->loopThrough($post);
        }
        return null;
    }

    /**
     * Loop through $POST array.
     * Transform objects to array.
     * transform values to string.
     * Transform HTML specials characters to ascii and escape.
     * Validate E-mail strings.
     *
     * @param $data
     *
     * @return array
     * @throws \Exception
     */
    private function loopThrough($data)
    {
        $output = (array)[];
        foreach ($data as $key => $value) {
            switch ($value) {
                case $this->isArrayOrObject($value):
                    $output[$key] = $this->getPost($value);
                    break;
                case $this->isMailAddress($key):
                    $output[$key] = $this->validateMail($key, $value);
                    // try catch make fail the test, catch must throw an exeption??

                    //          try {
                    //            $output[$key] = $this->validateMail($key, $value);
                    //          } catch (Exception $e) {
                    //            echo $e;
                    //          }
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
    private function isArrayOrObject($value): bool
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
    private function isMailAddress(string $key)
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
    private function toString($string): string
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
     * @throws \Exception
     */
    private function validateMail(string $key, string $mail): string
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
     * @return \Egulias\EmailValidator\Validation\MultipleValidationWithAnd
     */
    private function getMailValidationRules()
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