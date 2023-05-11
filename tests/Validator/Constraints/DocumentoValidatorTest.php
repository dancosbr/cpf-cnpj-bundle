<?php

declare(strict_types=1);

namespace Dancos\Bundle\CpfCnpjBundle\Tests\Validator\Constraints;

use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Dancos\Bundle\CpfCnpjBundle\Validator\Constraints\Documento;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;
use Dancos\Bundle\CpfCnpjBundle\Validator\Constraints\DocumentoValidator;

class DocumentoValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): DocumentoValidator
    {
        return new DocumentoValidator();
    }

    /**
     * @dataProvider getValidValues
     */
    public function testValidValues($value)
    {
        $this->validator->validate($value, new Documento());

        $this->assertNoViolation();
    }

    public static function getValidValues()
    {
        return [
            ['328.528.060-37'],
            ['997.749.390-18'],
            ['93191747095'],
            ['07277482034'],
        ];
    }

    public function testNullIsInvalid()
    {
        $this->validator->validate(null, new Documento());

        $this->buildViolation('O documento informado precisa ter 11 ou 14 caracteres')
            ->assertRaised();
    }

    public function testEmptyStringIsInvalid()
    {
        $this->validator->validate('', new Documento());

        $this->buildViolation('O documento informado precisa ter 11 ou 14 caracteres')
            ->assertRaised();
    }

    public function testArbitraryStringIsInvalid()
    {
        $this->validator->validate('a', new Documento());

        $this->buildViolation('O documento informado precisa ter 11 ou 14 caracteres')
            ->assertRaised();
    }

    public function testArbitraryIntegerIsInvalid()
    {
        $this->validator->validate(123, new Documento());

        $this->buildViolation('O documento informado precisa ter 11 ou 14 caracteres')
            ->assertRaised();
    }

    public function testWrongCpfIsInvalid()
    {
        $this->validator->validate('07277482031', new Documento());

        $this->buildViolation('O documento informado não é um CPF válido')
            ->assertRaised();
    }

    public function testWrongCnpjIsInvalid()
    {
        $this->validator->validate('11.885.649/0001-54', new Documento());

        $this->buildViolation('O documento informado não é um CNPJ válido')
            ->assertRaised();
    }
}
