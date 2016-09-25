VATINValidator
==============
[![Build Status](https://travis-ci.org/ricardonavarrom/VATINValidator.svg?branch=master)](https://travis-ci.org/ricardonavarrom/VATINValidator)
[![Coverage Status](https://coveralls.io/repos/github/ricardonavarrom/VATINValidator/badge.svg?branch=master)](https://coveralls.io/github/ricardonavarrom/VATINValidator?branch=master)
[![Total Downloads](https://poser.pugx.org/ricardonavarrom/vatin-validator/downloads)](https://packagist.org/packages/ricardonavarrom/vatin-validator)

A PHP library for for validating VAT identification numbers (VATINs).


Installation
------------
This library is available on [Packagist](https://packagist.org/packages/ricardonavarrom/vatin-validator).

You can install this library using composer

```bash
$ composer require ricardonavarrom/vatin-validator
```
or add the package to your composer.json file directly.


Basic usage
-----------
This library provides multiple located validators (view availables locales section).

```bash
$vatin = '56475114V';
$locatedValidator = new VATINValidatorES();
$vatinIsValid = $locatedValidator->validate($vatin);
```

Some located validators provides specials validations methods for its country.

```bash
$nif = '75096482X';
$nie = 'Z4503838Y';
$cif = 'A83472787';
$locatedValidator = new VATINValidatorES();
$nifIsValid = $locatedValidator->validateNIF($vatin);
$nieIsValid = $locatedValidator->validateNIE($vatin);
$cifIsValid = $locatedValidator->validateCIF($vatin);
```


Availables locales
------------------

| Locale        | Country           | Local name                                                                                                                                                                   |
| ------------- | ------------------| -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **es**        | Spain             | Número de Identificación Fiscal (for freelancers or singular persons), Número de Identidad de Extranjero (for foreigners) or Código de Identificación Fiscal (for companies) |
| **pt**        | Portugal          | Número de identificação fiscal (for freelancers or singular persons) or Número de Identificação de Pessoa Colectiva (for companies)                                          |
*We are working to implement more availables locales.*