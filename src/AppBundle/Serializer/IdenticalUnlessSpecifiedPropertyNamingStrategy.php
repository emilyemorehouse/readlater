<?php

namespace AppBundle\Serializer;

use JMS\Serializer\Metadata\PropertyMetadata;
use JMS\Serializer\Naming\PropertyNamingStrategyInterface;

/**
 * Class IdenticalUnlessSpecifiedPropertyNamingStrategy
 *
 * @package AppBundle\Serializer
 * @author Arkadius Stefanski <arkste@gmail.com>
 */
class IdenticalUnlessSpecifiedPropertyNamingStrategy implements PropertyNamingStrategyInterface
{
    public function translateName(PropertyMetadata $property)
    {
        $name = $property->serializedName;

        if (null !== $name) {
            return $name;
        }

        return $property->name;
    }
}
