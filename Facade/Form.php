<?php

namespace Olveneer\ActiveRecordBundle\Facade;


use Olveneer\ActiveRecordBundle\Facade\Facade;

class Form extends Facade
{
    public static function create(string $type, $data = null, array $options = array())
    {
        BundleChecker::checkForm();

        return self::get()->get('form.factory')->create($type, $data, $options);
    }

    public static function createBuilder($data = null, array $options = array())
    {
        BundleChecker::checkForm();

        return self::get()->get('form.factory')->createBuilder(FormType::class, $data, $options);
    }
}