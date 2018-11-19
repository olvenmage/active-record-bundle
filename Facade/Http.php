<?php

namespace Olveneer\ActiveRecordBundle\Facade;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class Http
 * @package Olveneer\ActiveRecordBundle\Facade
 */
class Http extends Facade
{
    /**
     * @return null|Request
     */
    public static function request(): ?Request
    {
        BundleChecker::checkHttp();

        return self::get()->get('request_stack')->getCurrentRequest();
    }

    /**
     * @param string $route
     * @param array $parameters
     * @param int $referenceType
     * @return string
     */
    public static function generateUrl(string $route, array $parameters = array(), int $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH): string
    {
        return self::get()->get('router')->generate($route, $parameters, $referenceType);
    }

    /**
     * Forwards the request to another controller.
     *
     * @param string $controller The controller name (a string like Bundle\BlogBundle\Controller\PostController::indexAction)
     *
     * @param array $path
     * @param array $query
     * @return Response
     * @final
     */
    public static function forward(string $controller, array $path = array(), array $query = array()): Response
    {
        $request = self::getRequest();

        $path['_controller'] = $controller;
        $subRequest = $request->duplicate($query, null, $path);

        return self::get()->get('http_kernel')->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
    }

    /**
     * Returns a RedirectResponse to the given URL.
     *
     * @final
     * @param string $url
     * @param int $status
     * @return RedirectResponse
     */
    public static function redirect(string $url, int $status = 302): RedirectResponse
    {
        return new RedirectResponse($url, $status);
    }

    /**
     * Returns a RedirectResponse to the given route with the given parameters.
     *
     * @final
     * @param string $route
     * @param array $parameters
     * @param int $status
     * @return RedirectResponse
     */
    public static function redirectToRoute(string $route, array $parameters = array(), int $status = 302): RedirectResponse
    {
        $route = self::get()->get('router')->generate($route, $parameters);

        return self::redirect($route, $status);
    }

    /**
     * Returns a JsonResponse that uses the serializer component if enabled, or json_encode.
     *
     * @final
     * @param $data
     * @param int $status
     * @param array $headers
     * @param array $context
     * @return JsonResponse
     */
    public static function json($data, int $status = 200, array $headers = array(), array $context = array()): JsonResponse
    {
        if (self::get()->has('serializer')) {
            $json = self::get()->get('serializer')->serialize($data, 'json', array_merge(array(
                'json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS,
            ), $context));

            return new JsonResponse($json, $status, $headers, true);
        }

        return new JsonResponse($data, $status, $headers);
    }
}
