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

    public function testNullIsValid()
    {
        $this->validator->validate(null, new Documento());

        $this->assertNoViolation();
    }

    public function testEmptyStringIsValid()
    {
        $this->validator->validate('', new Documento());

        $this->assertNoViolation();
    }

    public function testArbitraryStringIsInvalid()
    {
        $documento = new Documento();
        $this->validator->validate('a', $documento);

        $this->buildViolation($documento->messageSize)
            ->assertRaised();
    }

    public function testArbitraryIntegerIsInvalid()
    {
        $documento = new Documento();
        $this->validator->validate(123, $documento);

        $this->buildViolation($documento->messageSize)
            ->assertRaised();
    }

    public function testWrongCpfIsInvalid()
    {
        $documento = new Documento();
        $this->validator->validate('07277482031', $documento);

        $this->buildViolation($documento->messageCpf)
            ->assertRaised();
    }

    public function testWrongCnpjIsInvalid()
    {
        $documento = new Documento();
        $this->validator->validate('11.885.649/0001-54', $documento);

        $this->buildViolation($documento->messageCnpj)
            ->assertRaised();
    }

    public function testSizeMessageCanBeCustomized()
    {
        $documento = new Documento();
        $documento->messageSize = 'myMessageSize';
        $this->validator->validate('a', $documento);

        $this->buildViolation('myMessageSize')
            ->assertRaised();
    }

    public function testCpfMessageCanBeCustomized()
    {
        $documento = new Documento();
        $documento->messageCpf = 'myMessageCpf';
        $this->validator->validate('07277482031', $documento);

        $this->buildViolation('myMessageCpf')
            ->assertRaised();
    }

    public function testCnpjMessageCanBeCustomized()
    {
        $documento = new Documento();
        $documento->messageCnpj = 'myMessageCnpj';
        $this->validator->validate('11.885.649/0001-54', $documento);

        $this->buildViolation('myMessageCnpj')
            ->assertRaised();
    }
}
