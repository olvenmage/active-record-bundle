<?php

namespace Olveneer\ActiveRecordBundle\Facade;


use Olveneer\ActiveRecordBundle\Facade\Facade;

class Http extends Facade
{
    public static function getRequest()
    {
        BundleChecker::checkHttp();

        return self::get()->get('request_stack')->getCurrentRequest();
    }

    public static function generateUrl(string $route, array $parameters = array(), int $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH): string
    {
        return self::get()->get('router')->generate($route, $parameters, $referenceType);
    }

    /**
     * Forwards the request to another controller.
     *
     * @param string $controller The controller name (a string like Bundle\BlogBundle\Controller\PostController::indexAction)
     *
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
     */
    public static function redirect(string $url, int $status = 302): RedirectResponse
    {
        return new RedirectResponse($url, $status);
    }

    /**
     * Returns a RedirectResponse to the given route with the given parameters.
     *
     * @final
     */
    public static function redirectToRoute(string $route, array $parameters = array(), int $status = 302): RedirectResponse
    {
        return self::redirect(self::generateUrl($route, $parameters), $status);
    }

    /**
     * Returns a JsonResponse that uses the serializer component if enabled, or json_encode.
     *
     * @final
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