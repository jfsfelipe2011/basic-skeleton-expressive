<?php

declare(strict_types=1);

namespace AppTest\Unitary\Formatter\Validation;

use App\Formatter\Validation\ErrorArrayFormatter;
use PHPUnit\Framework\TestCase;

class ErrorArrayFromatterTest extends TestCase
{
    /** @var ErrorArrayFormatter */
    private $formatter;

    protected function setUp()
    {
        $this->formatter = new ErrorArrayFormatter();
    }

    /**
     * Testa a formatação de erros em formato string para array
     */
    public function testFormatterStringForArray()
    {
        $data = 'email-teste1,password-teste2,email-teste3';

        $formattedData = $this->formatter->format($data);

        $this->assertInternalType('array', $formattedData);
        $this->assertEquals(1, count($formattedData));
        $this->assertTrue(array_key_exists('errors', $formattedData));
    }

    /**
     * Testa o retorno de array vazio caso não tenha o padrão determinado
     */
    public function testReturnArrayVazioQuandoNaoPassadoStringPadrao()
    {
        $formattedData = $this->formatter->format('');

        $this->assertInternalType('array', $formattedData);
        $this->assertTrue(empty($formattedData));

        $formattedData = $this->formatter->format('stringsemnenhmavirgula');

        $this->assertInternalType('array', $formattedData);
        $this->assertTrue(empty($formattedData));

        $formattedData = $this->formatter->format('string,com,virgula,e,sem,traco');

        $this->assertInternalType('array', $formattedData);
        $this->assertTrue(empty($formattedData));
    }
}