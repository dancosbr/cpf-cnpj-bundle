<?php

declare(strict_types=1);

namespace Dancos\Bundle\CpfCnpjBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class DocumentoValidator extends ConstraintValidator
{
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

        if (strlen($value) === 14 && !$this->validateCnpj($value)) {
            $this->context->buildViolation($constraint->messageCnpj)->addViolation();
        }

        if (strlen($value) === 11 && !$this->validateCpf($value)) {
            $this->context->buildViolation($constraint->messageCpf)->addViolation();
        }
    }

    // code from Respect\Validation
    private function validateCnpj(
        #[\SensitiveParameter]
        string $input
    ): bool {
        if (!is_scalar($input)) {
            return false;
        }

        // Code ported from jsfromhell.com
        $bases = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $digits = $this->getDigits((string) $input);

        if (array_sum($digits) < 1) {
            return false;
        }

        if (count($digits) !== 14) {
            return false;
        }

        $n = 0;
        for ($i = 0; $i < 12; ++$i) {
            $n += $digits[$i] * $bases[$i + 1];
        }

        if ($digits[12] != (($n %= 11) < 2 ? 0 : 11 - $n)) {
            return false;
        }

        $n = 0;
        for ($i = 0; $i <= 12; ++$i) {
            $n += $digits[$i] * $bases[$i];
        }

        $check = ($n %= 11) < 2 ? 0 : 11 - $n;

        return $digits[13] == $check;
    }

    private function getDigits(string $input): array
    {
        return array_map(
            'intval',
            str_split(
                (string) preg_replace('/\D/', '', $input)
            )
        );
    }

    // code from Respect\Validation
    private function validateCpf(
        #[\SensitiveParameter]
        string $input
    ): bool {
        // Code ported from jsfromhell.com
        $c = preg_replace('/\D/', '', $input);

        if (mb_strlen($c) != 11 || preg_match('/^' . $c[0] . '{11}$/', $c) || $c === '01234567890') {
            return false;
        }

        $n = 0;
        for ($s = 10, $i = 0; $s >= 2; ++$i, --$s) {
            $n += $c[$i] * $s;
        }

        if ($c[9] != (($n %= 11) < 2 ? 0 : 11 - $n)) {
            return false;
        }

        $n = 0;
        for ($s = 11, $i = 0; $s >= 2; ++$i, --$s) {
            $n += $c[$i] * $s;
        }

        $check = ($n %= 11) < 2 ? 0 : 11 - $n;

        return $c[10] == $check;
    }
}
