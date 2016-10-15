<?php

namespace ricardonavarrom\VATINValidator\Validator;

class VATINValidatorES implements VATINValidatorLocatedInterface
{
    const CONTROL_DIGITS = 'TRWAGMYFPDXBNJZSQVHLCKE';
    const ORGANIZATION_TO_NUMBER_ARRAY = [
        0 => 'J', 1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E', 6 => 'F', 7 => 'G', 8 => 'H', 9 => 'I'
    ];

    public function validateNIF($vatin, $allowLowerCase = true)
    {
        $regexFormat = '/^([0-9]{8})([A-Za-z]{1})$/';
        if (1 !== preg_match($regexFormat, $vatin, $matches)) {
            return false;
        }

        list(, $numericPart, $controlDigit) = $matches;
        if ($allowLowerCase) {
            $controlDigit = strtoupper($controlDigit);
        }

        return $controlDigit === self::CONTROL_DIGITS[((int)$numericPart) % 23];
    }

    public function validateNIE($vatin, $allowLowerCase = true)
    {
        $regexFormat = '/^([X-Zx-z]{1})([0-9]{7})([A-Za-z]{1})$/';
        if (1 !== preg_match($regexFormat, $vatin, $matches)) {
            return false;
        }

        $firstChars = ['X' => 0, 'x' => 0, 'Y' => 1, 'y' => 1, 'Z' => 2, 'z' => 2];
        list(, $firstChar, $numericPart, $controlDigit) = $matches;
        if ($allowLowerCase) {
            $firstChar = strtoupper($firstChar);
            $controlDigit = strtoupper($controlDigit);
        }
        $firstCharValue = $firstChars[$firstChar];

        return $controlDigit === self::CONTROL_DIGITS[((int)$firstCharValue . $numericPart) % 23];
    }

    public function validateCIF($vatin, $allowLowerCase = true)
    {
        $regexFormat = '/^([ABCDEFGHJNPQRSUVWabcdefghjnpqrsuvw]{1})([0-9]{2})([0-9]{5})([A-Ja-j|0-9]{1})$/';
        if (1 !== preg_match($regexFormat, $vatin, $matches)) {
            return false;
        }

        list(, $organization, $provinceCode, $numericPart, $controlDigit) = $matches;

        if ($allowLowerCase) {
            $organization = strtoupper($organization);
            $controlDigit = strtoupper($controlDigit);
        } elseif (!$allowLowerCase && (ctype_lower($organization) || ctype_lower($controlDigit))) {
            return false;
        }

        $centralDigits = $provinceCode . $numericPart;
        $evenSum = $this->getCIFEvenSum($centralDigits);
        $oddDoubleSum = $this->getCIFOddDoubleSum($centralDigits);
        $controlDigitSum = $evenSum + $oddDoubleSum;
        $splitedControlDigitSum = str_split($controlDigitSum);
        $controlDigitSumUnits = $splitedControlDigitSum[count($splitedControlDigitSum) - 1];
        if ($controlDigitSumUnits > 0) {
            $controlDigitSumUnits = 10 - $controlDigitSumUnits;
        }

        return $this->validateNIFControlDigit($controlDigit, $organization, $controlDigitSumUnits);
    }

    public function validate($vatin, $allowLowerCase = true)
    {
        return $this->validateNIF($vatin, $allowLowerCase) || $this->validateNIE($vatin, $allowLowerCase)
        || $this->validateCIF($vatin, $allowLowerCase);
    }

    private function getCIFEvenSum($centralDigits)
    {
        $evenSum = 0;
        $centralDigitsNum = strlen($centralDigits);
        for ($i = 1; $i < $centralDigitsNum; $i += 2) {
            $evenSum += (int)$centralDigits[$i];
        }

        return $evenSum;
    }

    private function getCIFOddDoubleSum($centralDigits)
    {
        $oddDoubleSum = 0;
        $centralDigitsNum = strlen($centralDigits);
        for ($i = 0; $i < $centralDigitsNum; $i += 2) {
            $oddDoubleSum += (int)array_sum(str_split($centralDigits[$i] * 2));
        }

        return $oddDoubleSum;
    }

    private function validateNIFControlDigit($controlDigit, $organization, $controlDigitSumUnits)
    {
        if (false !== strpos('ABEH', $organization)) {
            $validControlDigits[] = $controlDigitSumUnits;
        } elseif (false !== strpos('PQSW', $organization)) {
            $validControlDigits[] = static::ORGANIZATION_TO_NUMBER_ARRAY[$controlDigitSumUnits];
        } else {
            $validControlDigits[] = $controlDigitSumUnits;
            $validControlDigits[] = static::ORGANIZATION_TO_NUMBER_ARRAY[$controlDigitSumUnits];
        }

        return in_array($controlDigit, $validControlDigits);
    }
}
