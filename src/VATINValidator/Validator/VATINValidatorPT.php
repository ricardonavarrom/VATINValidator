<?php

namespace ricardonavarrom\VATINValidator\Validator;

class VATINValidatorPT implements VATINValidatorLocatedInterface
{
    const VALIDS_FIRST_DIGITS_FOR_NIF = [1, 2];
    const VALIDS_FIRST_DIGITS_FOR_NIPC = [5, 6, 8, 9];

    public function validate($vatin, $allowLowerCase = true)
    {
        $regexFormat = '/^([0-9]{9})$/';
        if (1 !== preg_match($regexFormat, $vatin, $matches)) {
            return false;
        }

        $partialSum = $vatin[7] * 2 + $vatin[6] * 3 + $vatin[5] * 4 + $vatin[4] * 5 + $vatin[3] * 6 + $vatin[2] * 7 + $vatin[1] * 8 + $vatin[0] * 9;
        $module = $partialSum % 11;

        $controlDigit = 0;
        if (!in_array($module, [0, 1])) {
            $controlDigit = 11 - $module;
        }

        return $controlDigit === (int)$vatin[8];
    }

    public function validateNIF($vatin)
    {
        return $this->validate($vatin) && in_array($vatin[0], self::VALIDS_FIRST_DIGITS_FOR_NIF);
    }

    public function validateNIPC($vatin)
    {
        return $this->validate($vatin) && in_array($vatin[0], self::VALIDS_FIRST_DIGITS_FOR_NIPC);
    }
}