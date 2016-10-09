<?php

namespace ricardonavarrom\VATINValidator\Validator;

interface VATINValidatorLocatedInterface
{
    public function validate($vatin, $allowLowerCase = true);
}
