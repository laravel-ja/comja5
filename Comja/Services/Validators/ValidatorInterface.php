<?php

namespace Comja\Services\Validators;

interface ValidatorInterface
{

    public function validate( $param );

    public function getErrorMessage();

}