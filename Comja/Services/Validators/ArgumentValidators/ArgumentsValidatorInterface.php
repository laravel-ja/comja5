<?php

namespace Comja\Services\Validators\ArgumentsValidators;

interface ArgumentsValidatorInterface
{

    public function validate( $param );

    public function getErrorMessage();

}