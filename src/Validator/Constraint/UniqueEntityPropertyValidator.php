<?php

namespace App\Validator\Constraint;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;


class UniqueEntityPropertyValidator extends ConstraintValidator
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof UniqueEntityProperty) {
            throw new UnexpectedTypeException($constraint, EntityExists::class);
        }

        $criteria = new Criteria();
        // search for entity with same property value
        $criteria->where(Criteria::expr()->eq($constraint->entityProperty, $value->{$constraint->property}));

        if (!is_null($constraint->primaryKey)) {
            // exclude entities with same primary key value
            $criteria->andWhere(Criteria::expr()->neq($constraint->primaryKey, $value->{$constraint->primaryKey}));
        }

        $count = $this->entityManager->getRepository($constraint->entity)->matching($criteria)->count();

        if ($count > 0) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ entity }}', $constraint->entity)
                ->setParameter('{{ entityProperty }}', $constraint->entityProperty)
                ->setParameter('{{ value }}', $value->{$constraint->property})
                ->addViolation();
        }
    }
}
