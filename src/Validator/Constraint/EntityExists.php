<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Checks for the existence of an entity with the same property value, usually a primary key. False if it doesn't find anything.
 * Required for creating/editing entities with foreign keys.
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class EntityExists extends Constraint
{
    public string $message = 'Entity "{{ entity }}" with property "{{ property }}": "{{ value }}" does not exist';

    public string $property = 'id';

    public string $entity;

    /**
     * @param string $entity
     * @param string $property
     */
    public function __construct(string $entity, string $property = 'id')
    {
        parent::__construct([
            'entity' => $entity,
            'property' => $property
        ]);
    }
}
