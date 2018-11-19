<?php

namespace Olveneer\ActiveRecordBundle\Facade;

use Symfony\Component\Form\Extension\Core\Type\FormType;

/**
 * Class Form
 * @package Olveneer\ActiveRecordBundle\Facade
 */
class Form extends Facade
{
    /**
     * @param string $type
     * @param null $data
     * @param array $options
     * @return \Symfony\Component\Form\FormInterface
     */
    public static function create(string $type, $data = null, array $options = array())
    {
        BundleChecker::checkForm();

        return self::get()->get('form.factory')->create($type, $data, $options);
    }

    /**
     * @param null $data
     * @param array $options
     * @return \Symfony\Component\Form\FormBuilderInterface
     */
    public static function createBuilder($data = null, array $options = array())
    {
        BundleChecker::checkForm();

        return self::get()->get('form.factory')->createBuilder('Symfony\Component\Form\Extension\Core\Type\FormType', $data, $options);
    }

    /**
     * @param $form
     * @param $closure
     * @return bool
     */
    public static function handle($form, $closure)
    {
        $form->handleRequest(Http::request());

        if ($form->isSubmitted() && $form->isValid()) {
            return $closure($form->getData());
        }

        return false;
    }
}
