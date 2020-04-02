<?php


namespace MailSender\settings;

use ReflectionObject;
use ReflectionProperty;

/**
 * Class GetSettings
 *
 * @package MailSender\settings
 */
class GetSettings
{
    /**
     * @var array
     */
    private array $_settings;

    /**
     * @param $settings
     */
    public function __construct($settings)
    {
        $this->setSettings($settings);
    }

    /**
     * @param $settings
     */
    protected function setSettings($settings): void
    {
        $this->_settings = $this->takePublic($settings);
    }

    /**
     * Return an object with all the settings of the application.
     * Arrays of arrays become objects of objects.
     * Properties in provided class must be public.
     * All non public properties will be ignored.
     * Only arrays are accepted, otherwise
     *
     * use example :
     *     $settings = (new GetSettings($settingsClass))->getSettings();
     *     $myValue = $settings->firstArray->secondArray->myValue
     *
     * @return object
     */
    public function getSettings(): object
    {
        return (object)$this->processArray($this->_settings);
    }

    /**
     * Transform the provided key => value in object if it is an array.
     * Else, return tha provided key => value.
     *
     * @param $data
     * @return object
     */
    protected function processArray($data)
    {
        $output = [];
        foreach ($data as $key => $value) {
            if (!is_array($value)) {
                $output[$key] = $value;
            } else {
                $output[$key] = (object)$this->processArray($value);
            }
        }
        return (object)$output;
    }

    /**
     * @param $data
     * @return array
     */
    protected function takePublic($data): array
    {
        // https://stackoverflow.com/questions/2821927/detect-if-an-object-property-is-private-in-php
        // create a reflection object with only public properties.
        $reflection = new ReflectionObject((object)$data);
        $properties = $reflection->getProperties
        (
            ReflectionProperty::IS_PUBLIC
        );
        $isPublic = [];
        foreach ($properties as $property) {
            $isPublic[] = $property->getName();
        }

        // compare the $data array with the reflection object and return the
        // data array with only public properties.
        $output = [];
        foreach ((array)$data as $key => $value) {
            if (in_array($key, $isPublic)) {
                $output[$key] = $value;
            }
        }
        return (array)$output;
    }

}
