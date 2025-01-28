<?php

namespace Utils;

class Env
{


    public static function generateKey()
    {
        $simbols = '!@#$%^&*()-_=+';
        $number = 1234685219;
        $word = 'secret';
        $key = $word . $number . $simbols;
        return $key;
    }
}
