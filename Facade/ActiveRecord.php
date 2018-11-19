<?php
namespace Olveneer\ActiveRecordBundle\Facade;

use Olveneer\ActiveRecordBundle\Facade\Facade;

/**
 * Class ActiveRecord
 * @package Olveneer\ActiveRecordBundle\Facade
 */
class ActiveRecord extends Facade
{
    /**
     * @return \Doctrine\Bundle\DoctrineBundle\Registry|object
     */
    protected static function getDoctrine()
    {
        BundleChecker::checkDoctrine();

        return self::get()->get('doctrine');
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager|null|object
     */
    protected static function getEntityManager()
    {
        return self::getDoctrine()->getManagerForClass(get_called_class());
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected static function getRepository()
    {
        return self::getDoctrine()->getRepository(get_called_class());
    }

    /**
     * @return mixed
     */
    protected static function mirror()
    {
        return self::abstractMirror(self::getRepository());
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
