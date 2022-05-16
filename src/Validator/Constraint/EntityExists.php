<?php

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\MissingOptionsException;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class EntityExists extends Constraint
{
    public string $message = 'Entity "{{ entity }}" with property "{{ property }}": "{{ value }}" does not exist';

    public string $property = 'id';

    public ?object $entity;

    /**
     * EntityExists constructor.
     * @param null $options
     */
    public function __construct($options = null)
    {
        parent::__construct($options);

        if (null === $this->entity) {
            throw new MissingOptionsException(sprintf('Option "entity" must be given for constraint %s', __CLASS__), ['entity']);
        }
    }
}
