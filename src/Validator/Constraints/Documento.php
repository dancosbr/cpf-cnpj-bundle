<?php

declare(strict_types=1);

namespace Dancos\Bundle\CpfCnpjBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Documento extends Constraint
{
    public string $messageSize = 'O documento informado precisa ter 11 ou 14 caracteres numéricos';
    public string $messageCnpj = 'O documento informado não é um CNPJ válido';
    public string $messageCpf = 'O documento informado não é um CPF válido';

    public function validatedBy()
    {
        return static::class . 'Validator';
    }
}
