<?php

namespace Olveneer\ActiveRecordBundle\Facade;


use Olveneer\ActiveRecordBundle\Facade\Facade;
use Symfony\Component\Security\Core\User\UserInterface;

class Authorization extends Facade
{

    public static function isGranted($attributes, $subject = null): bool
    {
        BundleChecker::checkSecurity();

        return self::get()->get('security.authorization_checker')->isGranted($attributes, $subject);
    }

    public static function getUser()
    {
        BundleChecker::checkSecurity();

        $token = self::get()->get('security.token_storage')->getToken();

        if ($token) {
            return $token->getUser();
        }

        return false;
    }

    public static function login(UserInterface $user)
    {
        BundleChecker::checkSecurity();
        BundleChecker::checkSession();

        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());

        self::get()->get('security.token_storage')->setToken($token);
        self::get()->get('session')->set('_security_main', serialize($token));
    }
}