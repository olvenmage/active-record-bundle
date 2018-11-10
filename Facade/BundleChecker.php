<?php

namespace Olveneer\ActiveRecordBundle\Facade;


use Olveneer\ActiveRecordBundle\Facade\Facade;

class BundleChecker extends Facade
{
    public static function checkDoctrine()
    {
        if (!self::get()->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not registered in your application.');
        }
    }

    public static function checkSecurity()
    {
        if (!self::get()->has('security.token_storage')) {
            throw new \LogicException('The SecurityBundle is not registered in your application. Try running "composer require symfony/security-bundle".');
        }
    }

    public static function checkHttp()
    {
        if (!self::get()->has('request_stack')) {
            throw new \LogicException('The HttpFoundation component is not registered in your application. Try running "composer require symfony/http-foundation".');
        }
    }

    public static function checkForm()
    {
        if (!self::get()->has('form.factory')) {
            throw new \LogicException('The Form component is not registered in your application. Try running "composer require symfony/form".');
        }
    }

    public static function checkSession()
    {
        if (!self::get()->has('session')) {
            throw new \LogicException('You do not have sessions enabled in your application. Enable them in "config/packages/framework.yaml".');
        }
    }
}