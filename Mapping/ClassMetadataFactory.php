<?php

namespace Doctrine\Bundle\DoctrineBundle\Mapping;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\ClassMetadataFactory as BaseClassMetadataFactory;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

class ClassMetadataFactory extends BaseClassMetadataFactory
{
    /**
     * {@inheritDoc}
     */
    protected function doLoadMetadata($class, $parent, $rootEntityFound, array $nonSuperclassParents): void
    {
        parent::doLoadMetadata($class, $parent, $rootEntityFound, $nonSuperclassParents);

        $customGeneratorDefinition = $class->customGeneratorDefinition;

        if (! isset($customGeneratorDefinition['instance']) || ! $class instanceof ClassMetadataInfo) {
            return;
        }

        $class->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_CUSTOM);
        $class->setIdGenerator($customGeneratorDefinition['instance']);
        unset($customGeneratorDefinition['instance']);
        $class->setCustomGeneratorDefinition($customGeneratorDefinition);
    }
}
