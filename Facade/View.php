<?php

namespace Olveneer\ActiveRecordBundle\Facade;


use Olveneer\ActiveRecordBundle\Facade\Facade;
use Symfony\Component\HttpFoundation\Response;

class View extends Facade
{
    private static $params = [];


    public static function add($key, $value)
    {
        self::$params[$key] = $value;
    }

    public static function clear()
    {
        self::$params = [];
    }

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

    private static function getParameters($parameters)
    {
        $parameters = array_merge($parameters, self::$params);

        self::clear();

        return $parameters;
    }

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