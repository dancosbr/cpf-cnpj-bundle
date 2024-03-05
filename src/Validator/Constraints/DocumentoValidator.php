<?php

declare(strict_types=1);

namespace Dancos\Bundle\CpfCnpjBundle\Validator\Constraints;

use Dancos\Bundle\CpfCnpjBundle\Util\CpfCnpjUtil;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class DocumentoValidator extends ConstraintValidator
{
    public function __construct(
        #[Autowire()]
        private CpfCnpjUtil $cpfCnpjHelper,
    ) {
    }
    public function validate(
        #[\SensitiveParameter]
        mixed $value,
        Constraint $constraint
    ) {
        if (null === $value || '' === $value) {
            return;
        }

        if (!$constraint instanceof Documento) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__ . '\Documento');
        }

        $value = preg_replace('/[^0-9]/', '', (string) $value);

        if (strlen($value) !== 11 && strlen($value) !== 14 && isset($constraint->messageSize)) {
            $this->context->buildViolation($constraint->messageSize)->addViolation();
        }

        if (strlen($value) === 14 && !$this->cpfCnpjHelper->isCnpjValid($value)) {
            $this->context->buildViolation($constraint->messageCnpj)->addViolation();
        }

        if (strlen($value) === 11 && !$this->cpfCnpjHelper->isCpfValid($value)) {
            $this->context->buildViolation($constraint->messageCpf)->addViolation();
        }
    }
}
