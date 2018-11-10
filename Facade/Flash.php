<?php

namespace Olveneer\ActiveRecordBundle\Facade;


use Olveneer\ActiveRecordBundle\Facade\Facade;

class Flash extends Facade
{
    public static function add(string $type, string $message)
    {
        BundleChecker::checkSession();

        self::get()->get('session')->getFlashBag()->add($type, $message);
}
}