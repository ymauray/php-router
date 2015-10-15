<?php

namespace PhpRouter;


class Tools
{
    public static function camelCaseToHyphanate($string) {
        if ($string === null) { return null; }
        $a = self::splitCamelCase($string);
        $camelCase = strtolower(join($a, '-'));
        return $camelCase;
    }

    public static function splitCamelCase($string) {
        if ($string === null) { return null; }
        $re = '/(?<=[a-z])(?=[A-Z])/x';
        $a = preg_split($re, $string);
        return $a;
    }
}