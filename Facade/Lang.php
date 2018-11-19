<?php

namespace Olveneer\ActiveRecordBundle\Facade;

/**
 * Class Lang
 * @package Olveneer\ActiveRecordBundle\Facade
 */
class Lang extends Facade
{
    private static function getTranslator()
    {
        BundleChecker::checkTranslation();

        return self::get()->get('translator');
    }

    /**
     * @see TranslatorInterface::trans()
     * @param $id
     * @param array $parameters
     * @param string $domain
     * @param null $locale
     */
    public static function trans($id, array $parameters = array(), $domain = 'messages', $locale = null)
    {
        self::getTranslator()->trans($id, $parameters, $domain, $locale);
    }

    /**
     * @see TranslatorInterface::transChoice()
     * @param $id
     * @param $number
     * @param array $parameters
     * @param string $domain
     * @param null $locale
     * @return string
     */
    public static function transChoice($id, $number, array $parameters = array(), $domain = 'messages', $locale = null)
    {
        return self::getTranslator()->transChoice($id, $number, $parameters, $domain, $locale);
    }

    /**
     * @return mixed
     */
    public static function getLocale()
    {
        return self::getTranslator()->getLocale();
    }

    /**
     * @param $locale
     */
    public static function setLocale($locale)
    {
        self::getTranslator()->setLocale($locale);
    }
}
