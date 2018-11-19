<?php

namespace Olveneer\ActiveRecordBundle\Facade;

use Olveneer\ActiveRecordBundle\Facade\Facade;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class View
 * @package Olveneer\ActiveRecordBundle\Facade
 */
class View extends Facade
{
    private static $params = [];

    /**
     * @param $key
     * @param $value
     */
    public static function add($key, $value)
    {
        self::$params[$key] = $value;
    }

    /**
     * @param $form
     * @param string $key
     */
    public static function addForm($form, string $key = 'form')
    {
        self::add($key, $form->createView());
    }

    /**
     * @param array $values
     */
    public static function addMultiple(array $values)
    {
        self::$params = array_merge(self::$params, $values);
    }

    public static function clear()
    {
        self::$params = [];
    }

    /**
     * @param string $view
     * @param array $parameters
     * @param null $response
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public static function render(string $view, array $parameters = array(), $response = null): Response
    {
        $parameters = self::getParameters($parameters);

        if (self::get()->has('templating')) {
            $content = self::get()->get('templating')->render($view, $parameters);
        } elseif (self::get()->has('twig')) {
            $content = self::get()->get('twig')->render($view, $parameters);
        } else {
            throw new \LogicException('You can not use the "render" method if the Templating Component or the Twig Bundle are not available. Try running "composer require symfony/twig-bundle".');
        }

        if (null === $response) {
            $response = new Response();
        }

        $response->setContent($content);

        return $response;
    }

    /**
     * @param $parameters
     * @return array
     */
    private static function getParameters($parameters)
    {
        $parameters = array_merge($parameters, self::$params);

        self::clear();

        return $parameters;
    }

    /**
     * @param string $view
     * @param array $parameters
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public static function renderView(string $view, array $parameters = array()): string
    {
        $parameters = self::getParameters($parameters);

        if (self::get()->has('templating')) {
            return self::get()->get('templating')->render($view, $parameters);
        }

        if (!self::get()->has('twig')) {
            throw new \LogicException('You can not use the "renderView" method if the Templating Component or the Twig Bundle are not available. Try running "composer require symfony/twig-bundle".');
        }

        return self::get()->get('twig')->render($view, $parameters);
    }
}
