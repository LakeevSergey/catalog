<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::IS_REPEATABLE)]
class UniqueEntityProperty extends Constraint
{
    public string $entity;

    public string $property;

    public string $message;

    public string $entityProperty;

    public ?string $primaryKey;

    public function __construct(string $entity, string $property, ?string $entityProperty = null, ?string $primaryKey = null, string $message = 'Entity "{{ entity }}" with property "{{ property }}": "{{ value }}" exists')
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
