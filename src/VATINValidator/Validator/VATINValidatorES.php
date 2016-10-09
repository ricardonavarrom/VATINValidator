<?php

namespace ricardonavarrom\VATINValidator\Validator;

class VATINValidatorES implements VATINValidatorLocatedInterface
{
    const CONTROL_DIGITS = 'TRWAGMYFPDXBNJZSQVHLCKE';

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
        }
        $centralDigits = $provinceCode . $numericPart;
        $pairSum = $this->getCIFPairSum($centralDigits);
        $oddDoubleSum = $this->getCIFOddDoubleSum($centralDigits);
        $digitControlSum = $pairSum + $oddDoubleSum;

        return $controlDigit == $this->getCIFDigitControl($organization, $digitControlSum);
    }

    public function validate($vatin, $allowLowerCase = true)
    {
        return $this->validateNIF($vatin, $allowLowerCase) || $this->validateNIE($vatin, $allowLowerCase)
        || $this->validateCIF($vatin, $allowLowerCase);
    }

    private function getCIFPairSum($centralDigits)
    {
        $pairSum = 0;
        for ($i = 1; $i < strlen($centralDigits); $i += 2) {
            $pairSum += (int)$centralDigits[$i];
        }

        return $pairSum;
    }

    private function getCIFOddDoubleSum($centralDigits)
    {
        $oddDoubleSum = 0;
        for ($i = 0; $i < strlen($centralDigits); $i += 2) {
            $oddDoubleSum += (int)array_sum(str_split($centralDigits[$i] * 2));
        }

        return $oddDoubleSum;
    }

    private function getCIFDigitControl($organization, $digitControlSum)
    {
        $splitedDigitControlSum = str_split($digitControlSum);
        $digitControlSumUnits = $splitedDigitControlSum[count($splitedDigitControlSum) - 1];
        if ($digitControlSumUnits > 0) {
            $digitControlSumUnits = 10 - $digitControlSumUnits;
        }

        if (!strpos('PQSW', $organization)) {
            $digitControl = $digitControlSumUnits;
        } else {
            $organizationToNumberArray = [
                0 => 'J', 1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E', 6 => 'F', 7 => 'G', 8 => 'H', 9 => 'I'
            ];
            $digitControl = $organizationToNumberArray[$digitControlSumUnits];
        }

        return $digitControl;
    }
}
