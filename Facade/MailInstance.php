<?php

namespace Olveneer\ActiveRecordBundle\Facade;


use Symfony\Component\DependencyInjection\Container;

/**
 * Class MailInstance
 * @package Olveneer\ActiveRecordBundle\Facade
 */
class MailInstance extends \Swift_Message
{
    /** @var Container */
    private $container;

    /**
     * MailInstance constructor.
     * @param null|string $subject
     * @param null|string $body
     * @param null|string $contentType
     * @param null|string $charset
     * @param $container
     */
    public function __construct(?string $subject = null, ?string $body = null, ?string $contentType = null, ?string $charset = null, $container)
    {
        parent::__construct($subject, $body, $contentType, $charset);

        $this->container = $container;
    }

    /**
     * @param string $view
     * @param array $parameters
     * @return $this
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function html(string $view, array $parameters = array())
    {
        if ($this->container->has('templating')) {
            $template = $this->container->get('templating')->render($view, $parameters);
        }

        if (!$this->container->has('twig')) {
            throw new \LogicException('You can not use the "renderView" method if the Templating Component or the Twig Bundle are not available. Try running "composer require symfony/twig-bundle".');
        }

        $template = $this->container->get('twig')->render($view, $parameters);

        $this->setBody($template, 'text/html');

        return $this;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function send()
    {
        $this->container->get('swiftmailer.mailer.abstract')->send($this);

        return $this;
    }
}
