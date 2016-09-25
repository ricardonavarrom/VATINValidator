<?php

namespace ricardonavarrom\VATINValidator\Tests\Validator;

use ricardonavarrom\VATINValidator\Validator\VATINValidatorPT;

class VATINValidatorPTTest extends \PHPUnit_Framework_TestCase
{
    /** @var VATINValidatorPT */
    private $validator;

    protected function setUp()
    {
        parent::setUp();

        $this->validator = new VATINValidatorPT();
    }

    /** @test */
    public function validate_withNull_returnsFalse()
    {
        $vatin = null;

        $validated = $this->validator->validate($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validate_withEmptyString_returnsFalse()
    {
        $vatin = '';

        $validated = $this->validator->validate($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validate_withAlphabeticChar_returnsFalse()
    {
        $vatin = 'A00105308';

        $validated = $this->validator->validate($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validate_withSmallerLenght_returnsFalse()
    {
        $vatin = '50010530';

        $validated = $this->validator->validate($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validate_withLargerLenght_returnsFalse()
    {
        $vatin = '5001053089';

        $validated = $this->validator->validate($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validate_withBadControlDigit_returnsFalse()
    {
        $vatin = '500105305';

        $validated = $this->validator->validate($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validate_withValidVATIN_returnsTrue()
    {
        $vatin = '500105308';

        $validated = $this->validator->validate($vatin);

        $this->assertTrue($validated);
    }


    /** @test */
    public function validateNIF_withBadNIF_returnsFalse()
    {
        $vatin = '500105308';

        $validated = $this->validator->validateNIF($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateNIF_withValidNIF_returnsTrue()
    {
        $vatin = '123456789';

        $validated = $this->validator->validateNIF($vatin);

        $this->assertTrue($validated);
    }

    /** @test */
    public function validateNIPC_withBadNIPC_returnsFalse()
    {
        $vatin = '123456789';

        $validated = $this->validator->validateNIPC($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateNIPC_withValidNIPC_returnsTrue()
    {
        $vatin = '500105308';

        $validated = $this->validator->validateNIPC($vatin);

        $this->assertTrue($validated);
    }
}
