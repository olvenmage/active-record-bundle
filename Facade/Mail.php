<?php

namespace Olveneer\ActiveRecordBundle\Facade;

/**
 * Class Mail
 * @package Olveneer\ActiveRecordBundle\Facade
 */
class Mail extends Facade
{
    /**
     * @param null|string $subject
     * @param null|string $body
     * @param null|string $contentType
     * @param null|string $charset
     * @return MailInstance
     */
    public static function create(?string $subject = null, ?string $body = null, ?string $contentType = null, ?string $charset = null)
    {
        return new MailInstance($subject, $body, $contentType, $charset, self::get());
    }
}
