<?php

if (!function_exists('c5_trans')) {
    function c5_trans($message)
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return mb_convert_encoding($message, 'SJIS', 'UTF-8');
        }

        return $message;
    }
}
