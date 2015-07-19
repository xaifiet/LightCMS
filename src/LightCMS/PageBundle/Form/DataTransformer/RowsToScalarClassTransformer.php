<?php

namespace LightCMS\PageBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\PersistentCollection;
use Doctrine\Common\Collections\ArrayCollection;

use LightCMS\CoreBundle\Util\ScalarUtil;

use LightCMS\PageBundle\Entity\Row;
use LightCMS\PageBundle\Entity\Page;


class RowsToScalarClassTransformer implements DataTransformerInterface
{

    private $objectManager;

    private $page;


    public function __construct(ObjectManager $objectManager, Page $page)
    {
        $this->objectManager = $objectManager;
        $this->page = $page;
    }

    public function transform($entities)
    {

        if (is_null($entities)) {
            return array();
        }

        if ($entities instanceof PersistentCollection) {
            $entities = $entities->toArray();
        }

        if (is_array($entities) or $entities instanceof ArrayCollection) {
            $result = array();

            foreach ($entities as $entity) {

                $result[] = $this->entityToScalarClass($entity);
            }

            $results = new ArrayCollection($result);
            return $results;
        }
        return $this->entityToScalarClass($entities);
    }

    protected function entityToScalarClass($entity)
    {
        $scalar = new ScalarUtil();
        $scalar->setEntityClassName(get_class($entity));
        $scalar->setIdentifierFieldName($this->objectManager
            ->getClassMetadata(get_class($entity))
            ->getIdentifierFieldNames());
        foreach (get_class_methods(get_class($entity)) as $method) {
            if (substr($method, 0, 3) == 'get') {
                $field = substr($method, 3);
                $scalar->$field = $entity->$method();
            }
        }
        return $scalar;
    }

    public function reverseTransform($scalars)
    {

        if (!$scalars) {
            return null;
        }

        $entities = array();
        foreach ($scalars as $scalar) {

            $entityClassName = $scalar->entityClassName;

            if (is_null($entityClassName)) {
                $entity = new Row();
                $entity->setPage($this->page);
            } else {
                $identifierFieldName = $scalar->identifierFieldName[0];

                $repository = $this->objectManager->getRepository($entityClassName);

                $entity = $repository->find($scalar->$identifierFieldName);
            }

            $entities[] = $entity;
        }

        return $entities;
    }

}

?>