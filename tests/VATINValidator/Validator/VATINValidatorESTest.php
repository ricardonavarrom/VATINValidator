<?php

namespace ricardonavarrom\VATINValidator\Tests\Validator;

use ricardonavarrom\VATINValidator\Validator\VATINValidatorES;

class VATINValidatorESTest extends \PHPUnit_Framework_TestCase
{
    /** @var VATINValidatorES */
    private $validator;

    protected function setUp()
    {
        parent::setUp();

        $this->validator = new VATINValidatorES();
    }

    /** @test */
    public function validateNIF_withNull_returnsFalse()
    {
        $vatin = null;

        $validated = $this->validator->validateNIF($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateNIF_withEmptyString_returnsFalse()
    {
        $vatin = '';

        $validated = $this->validator->validateNIF($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateNIF_withNoString_returnsFalse()
    {
        $vatin = 82189471;

        $validated = $this->validator->validateNIF($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateNIF_withSmallerLenght_returnsFalse()
    {
        $vatin = '8218947Y';

        $validated = $this->validator->validateNIF($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateNIF_withLargerLenght_returnsFalse()
    {
        $vatin = '821894710Y';

        $validated = $this->validator->validateNIF($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateNIF_withoutControlDigit_returnsFalse()
    {
        $vatin = '821894710';

        $validated = $this->validator->validateNIF($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateNIF_withAlphabeticString_returnsFalse()
    {
        $vatin = 'AAAAAAAAA';

        $validated = $this->validator->validateNIF($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateNIF_withBadControlDigitPosition_returnsFalse()
    {
        $vatin = 'Y82189471';

        $validated = $this->validator->validateNIF($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateNIF_withBadControlDigit_returnsFalse()
    {
        $vatin = '82189471R';

        $validated = $this->validator->validateNIF($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateNIF_withAlphabeticCharInNumericPart_returnsFalse()
    {
        $vatin = '821894A1Y';

        $validated = $this->validator->validateNIF($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateNIF_withLowerControlDigitAndNoAllowLowerCase_returnsFalse()
    {
        $vatin = '82189471y';

        $validated = $this->validator->validateNIF($vatin, false);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateNIF_withLowerControlDigitAndAllowLowerCase_returnsTrue()
    {
        $vatin = '82189471y';

        $validated = $this->validator->validateNIF($vatin);

        $this->assertTrue($validated);
    }

    /** @test */
    public function validateNIF_withGoodVATIN_returnsTrue()
    {
        $vatin = '82189471Y';

        $validated = $this->validator->validateNIF($vatin);

        $this->assertTrue($validated);
    }

    /** @test */
    public function validateNIE_withNull_returnsFalse()
    {
        $vatin = null;

        $validated = $this->validator->validateNIE($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateNIE_withEmptyString_returnsFalse()
    {
        $vatin = '';

        $validated = $this->validator->validateNIE($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateNIE_withNoString_returnsFalse()
    {
        $vatin = 156826661;

        $validated = $this->validator->validateNIE($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateNIE_withSmallerLenght_returnsFalse()
    {
        $vatin = 'Z568266S';

        $validated = $this->validator->validateNIE($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateNIE_withLargerLenght_returnsFalse()
    {
        $vatin = 'Z56826666S';

        $validated = $this->validator->validateNIE($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateNIE_withBadFirstChar_returnsFalse()
    {
        $vatin = 'A5682666S';

        $validated = $this->validator->validateNIE($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateNIE_withoutFirstChar_returnsFalse()
    {
        $vatin = '45682666S';

        $validated = $this->validator->validateNIE($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateNIE_withAlphabeticCharInNumericPart_returnsFalse()
    {
        $vatin = 'Z568A666S';

        $validated = $this->validator->validateNIE($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateNIE_withoutControlDigit_returnsFalse()
    {
        $vatin = 'Z56826663';

        $validated = $this->validator->validateNIE($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateNIE_withLowerFirstCharAndAllowLowerCase_returnsTrue()
    {
        $vatin = 'z5682666S';

        $validated = $this->validator->validateNIE($vatin);

        $this->assertTrue($validated);
    }

    /** @test */
    public function validateNIE_withLowerFirstCharAndNoAllowLowerCase_returnsFalse()
    {
        $vatin = 'z5682666S';

        $validated = $this->validator->validateNIE($vatin, false);

        $this->assertTrue($validated);
    }

    /** @test */
    public function validateNIE_withLowerControlDigitAndAllowLowerCase_returnsTrue()
    {
        $vatin = 'Z5682666s';

        $validated = $this->validator->validateNIE($vatin);

        $this->assertTrue($validated);
    }

    /** @test */
    public function validateNIE_withLowerControlDigitAndNoAllowLowerCase_returnsFalse()
    {
        $vatin = 'Z5682666s';

        $validated = $this->validator->validateNIE($vatin, false);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateNIE_withGoodVATIN_returnsTrue()
    {
        $vatin = 'Z5682666S';

        $validated = $this->validator->validateNIE($vatin);

        $this->assertTrue($validated);
    }

    /** @test */
    public function validateCIF_withNull_returnsFalse()
    {
        $vatin = null;

        $validated = $this->validator->validateCIF($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateCIF_withEmptyString_returnsFalse()
    {
        $vatin = '';

        $validated = $this->validator->validateCIF($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateCIF_withNoString_returnsFalse()
    {
        $vatin = 119297300;

        $validated = $this->validator->validateCIF($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateCIF_withSmallerLenght_returnsFalse()
    {
        $vatin = 'Q1929730';

        $validated = $this->validator->validateCIF($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateCIF_withLargerLenght_returnsFalse()
    {
        $vatin = 'Q1929730H9';

        $validated = $this->validator->validateCIF($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateCIF_withBadOrganizationCode_returnsFalse()
    {
        $vatin = 'I1929730H';

        $validated = $this->validator->validateCIF($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateCIF_withNumberOrganizationCode_returnsFalse()
    {
        $vatin = '11929730H';

        $validated = $this->validator->validateCIF($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateCIF_withBadProvinceCode_returnsFalse()
    {
        $vatin = 'Q1A29730H';

        $validated = $this->validator->validateCIF($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateCIF_withAlphabethicCharInNumericPart_returnsFalse()
    {
        $vatin = 'Q192A730H';

        $validated = $this->validator->validateCIF($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateCIF_withBadAlphabeticCharInControlDigit_returnsFalse()
    {
        $vatin = 'Q1929730K';

        $validated = $this->validator->validateCIF($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateCIF_withBadControlDigit_returnsFalse()
    {
        $vatin = 'Q1929730A';

        $validated = $this->validator->validateCIF($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateCIF_withGoodAlphabeticControlDigit_returnsTrue()
    {
        $vatin = 'Q1929730H';

        $validated = $this->validator->validateCIF($vatin);

        $this->assertTrue($validated);
    }

    /** @test */
    public function validateCIF_withGoodNumericControlDigit_returnsTrue()
    {
        $vatin = 'A58818501';

        $validated = $this->validator->validateCIF($vatin);

        $this->assertTrue($validated);
    }

    /** @test */
    public function validateCIF_withGoodMixedControlDigitOptionAlphanumeric_returnsTrue()
    {
        $vatin = 'F1066852C';

        $validated = $this->validator->validateCIF($vatin);

        $this->assertTrue($validated);
    }

    /** @test */
    public function validateCIF_withGoodMixedControlDigitOptionNumeric_returnsTrue()
    {
        $vatin = 'F10668523';

        $validated = $this->validator->validateCIF($vatin);

        $this->assertTrue($validated);
    }

    /** @test */
    public function validateCIF_withGoodVATINAndLowerOrganizationAndNoAllowedLowerCase_returnsFalse()
    {
        $vatin = 'q1929730H';

        $validated = $this->validator->validateCIF($vatin, false);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateCIF_withGoodVATINAndLowerOrganizationAndAllowedLowerCase_returnsTrue()
    {
        $vatin = 'q1929730H';

        $validated = $this->validator->validateCIF($vatin);

        $this->assertTrue($validated);
    }

    /** @test */
    public function validateCIF_withGoodVATINAndLowerControlDigitAndNoAllowedLowerCase_returnsFalse()
    {
        $vatin = 'Q1929730h';

        $validated = $this->validator->validateCIF($vatin, false);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validateCIF_withGoodVATINAndLowerControlDigitAndAllowedLowerCase_returnsTrue()
    {
        $vatin = 'Q1929730h';

        $validated = $this->validator->validateCIF($vatin);

        $this->assertTrue($validated);
    }

    /** @test */
    public function validate_withBadNIF_returnsFalse()
    {
        $vatin = '81287258K';

        $validated = $this->validator->validate($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validate_withGoodNIF_returnsTrue()
    {
        $vatin = '81287258Z';

        $validated = $this->validator->validate($vatin);

        $this->assertTrue($validated);
    }

    /** @test */
    public function validate_withBadNIE_returnsFalse()
    {
        $vatin = 'Y7026253A';

        $validated = $this->validator->validate($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validate_withGoodNIE_returnsTrue()
    {
        $vatin = 'Y7026253C';

        $validated = $this->validator->validate($vatin);

        $this->assertTrue($validated);
    }

    /** @test */
    public function validate_withBadCIF_returnsFalse()
    {
        $vatin = 'Q9137158A';

        $validated = $this->validator->validate($vatin);

        $this->assertFalse($validated);
    }

    /** @test */
    public function validate_withGoodCIF_returnsTrue()
    {
        $vatin = 'Q9137158C';

        $validated = $this->validator->validate($vatin);

        $this->assertTrue($validated);
    }
}
