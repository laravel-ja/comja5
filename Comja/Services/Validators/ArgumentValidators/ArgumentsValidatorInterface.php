<?php

namespace Comja\Services\Validators\ArgumentValidators;

interface ArgumentsValidatorInterface
{

    public function validate( $param );

    public function getErrorMessage();

}