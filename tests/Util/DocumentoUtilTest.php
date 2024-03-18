<?php

declare(strict_types=1);

namespace Dancos\Bundle\CpfCnpjBundle\Tests\Validator\Constraints;

use Dancos\Bundle\CpfCnpjBundle\Util\DocumentoUtil;
use PHPUnit\Framework\TestCase;

class DocumentoUtilTest extends TestCase
{
    public static function cpfDataProvider(): array
    {
        return [
            ['32852806037', true],
            ['99774939018', true],
            ['93191747095', true],
            ['07277482034', true],
            ['12345678900', false],
            ['643.025.450-03', true],
            ['64302545003', true],
            ['123.456.789-00', false],
        ];
    }

    public static function cnpjDataProvider(): array
    {
        return [
            ['93191747000195', false],
            ['07277482000134', false],
            ['32852806037', false],
            ['99774939018', false],
            ['31.222.884/0001-52', true],
            ['35.420.151/0001-83', true],
            ['22264449000108', true],
        ];
    }

    /**
     * @dataProvider cpfDataProvider
     */
    public function testIsCpfValid(string $cpf, bool $expected): void
    {
        $documentoUtil = new DocumentoUtil();
        $this->assertEquals($expected, $documentoUtil->isCpfValid($cpf));
    }
    

    /**
     * @dataProvider cnpjDataProvider
     */
    public function testIsCnpjValid(string $cnpj, bool $expected): void
    {
        $documentoUtil = new DocumentoUtil();
        $this->assertEquals($expected, $documentoUtil->isCnpjValid($cnpj));
    }
}
