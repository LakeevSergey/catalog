<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Checks if there are entities with the same property value. False if it finds it.
 * Required for creating/editing entities with unique properties.
 */
#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::IS_REPEATABLE)]
class UniqueEntityProperty extends Constraint
{
    public string $entity;

    public string $property;

    public string $message;

    public string $entityProperty;

    public ?string $primaryKey;

    /**
     * @param string $entity entity class, for example 'App\Entity\Product'
     * @param string $property property to check
     * @param string|null $entityProperty entity property to check, keep null if same as $property
     * @param string|null $primaryKey primary key of object and entity. Needed if we are going to edit some object
     * @param string $message error message
     */
    public function __construct(
        string  $entity,
        string  $property,
        ?string $entityProperty = null,
        ?string $primaryKey = null,
        string  $message = 'Entity "{{ entity }}" with property "{{ entityProperty  }}": "{{ value }}" exists'
    )
    {
        if (is_null($entityProperty)) {
            $entityProperty = $property;
        }

        parent::__construct([
            'entity' => $entity,
            'property' => $property,
            'message' => $message,
            'entityProperty' => $entityProperty,
            'primaryKey' => $primaryKey
        ]);
    }

    public function getTargets(): array|string
    {
        return self::CLASS_CONSTRAINT;
    }
}
