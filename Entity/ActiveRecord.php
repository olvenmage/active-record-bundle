<?php
namespace Olveneer\ActiveRecordBundle\Entity;

use Olveneer\ActiveRecordBundle\DependencyInjection\Container;

class ActiveRecord extends Container
{
    protected static function getDoctrine()
    {
        if (!self::$container->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not registered in your application.');
        }
        return self::$container->get('doctrine');
    }
    protected static function getEntityManager()
    {
        return self::getDoctrine()->getManagerForClass(get_called_class());
    }
    protected static function getRepository()
    {
        return self::getDoctrine()->getRepository(get_called_class());
    }
    /**
     * @param $id
     * @return null|static
     */
    public static function find($id)
    {
        return self::getRepository()->find($id);
    }
    /**
     * @return static[]
     */
    public static function findAll()
    {
        return self::getRepository()->findAll();
    }
    /**
     * @return static[]
     */
    public static function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return self::getRepository()->findBy($criteria, $orderBy, $limit, $offset);
    }
    /**
     * @return null|static
     */
    public static function findOneBy(array $criteria)
    {
        return self::getRepository()->findOneBy($criteria);
    }
}