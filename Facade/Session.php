<?php

namespace Olveneer\ActiveRecordBundle\Facade;

/**
 * Class Session
 * @package Olveneer\ActiveRecordBundle\Facade
 */
class Session extends Facade
{

    /**
     * @return object|\Symfony\Component\HttpFoundation\Session\Session
     */
    private static function getSession()
    {
        BundleChecker::checkSession();

        return self::get()->get('session');
    }

    /**
     * @return object|\Symfony\Component\HttpFoundation\Session\Session
     */
    public static function current()
    {
        return self::getSession();
    }

    /**
     * @param string $message
     * @param string $type
     * @return mixed
     */
    public static function flash(string $message, string $type = 'success')
    {
        return self::getSession()->getFlashBag()->add($type, $message);
    }
}
