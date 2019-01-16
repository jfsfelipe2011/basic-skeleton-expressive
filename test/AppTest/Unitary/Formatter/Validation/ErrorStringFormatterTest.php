<?php

declare(strict_types=1);

namespace AppTest\Unitary\Formatter\Validation;

use App\Formatter\Validation\ErrorStringFormatter;
use PHPUnit\Framework\TestCase;

class ErrorStringFormatterTest extends TestCase
{
    /** @var ErrorStringFormatter */
    private $formatter;


    protected function setUp()
    {
        $this->formatter = new ErrorStringFormatter();
    }

    /**
     * Testa a formatação de erros em formato array para string
     */
    public function testFormatterArrayErrorsForString()
    {
        $data = [
            'email'    => [
                'validator1' => 'message1',
                'validator2' => 'message2'
            ],
            'password' => [
                'validator3' => 'message3'
            ]
        ];

        $formattedData = $this->formatter->format($data);

        $this->assertInternalType('string', $formattedData);
        $this->assertContains('email-message1', $formattedData);
        $this->assertContains('email-message2', $formattedData);
        $this->assertContains('password-message3', $formattedData);
        $this->assertNotContains(',', substr($formattedData,  -1));

        $data = [
            'email'    => [
                'message1',
                'message2'
            ],
            'password' => [
                'message3'
            ]
        ];

        $formattedData = $this->formatter->format($data);

        $this->assertInternalType('string', $formattedData);
        $this->assertContains('email-message1', $formattedData);
        $this->assertContains('email-message2', $formattedData);
        $this->assertContains('password-message3', $formattedData);
        $this->assertNotContains(',', substr($formattedData,  -1));
    }

    /**
     * Testa o retorno de string vazia caso não tenha o padrão determinado
     */
    public function testReturnStringVaziaQuandoNaoPassadoPadraDeArray()
    {
        $formattedData = $this->formatter->format([]);

        $this->assertInternalType('string', $formattedData);
        $this->assertTrue(empty($formattedData));

        $formattedData = $this->formatter->format(['teste', 'teste2']);

        $this->assertInternalType('string', $formattedData);
        $this->assertTrue(empty($formattedData));

        $formattedData = $this->formatter->format(['teste' => [], 'teste2' => []]);

        $this->assertInternalType('string', $formattedData);
        $this->assertTrue(empty($formattedData));
    }
}