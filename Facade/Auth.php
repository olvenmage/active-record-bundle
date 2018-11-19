<?php

namespace Olveneer\ActiveRecordBundle\Facade;


use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Class Auth
 * @package Olveneer\ActiveRecordBundle\Facade
 */
class Auth extends Facade
{

    /**
     * @param $attributes
     * @param null $subject
     * @return bool
     */
    public static function isGranted($attributes, $subject = null): bool
    {
        BundleChecker::checkSecurity();

        return self::get()->get('security.authorization_checker')->isGranted($attributes, $subject);
    }

    /**
     * @return null|object|string
     */
    public static function user()
    {
        BundleChecker::checkSecurity();

        if (null === $token = self::get()->get('security.token_storage')->getToken()) {
            return null;
        }

        if (!\is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return null;
        }

        return $user;
    }

    /**
     * @param UserInterface $user
     */
    public static function login(UserInterface $user)
    {
        BundleChecker::checkSecurity();
        BundleChecker::checkSession();

        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());

        self::get()->get('security.token_storage')->setToken($token);
        self::get()->get('session')->set('_security_main', serialize($token));
    }
}