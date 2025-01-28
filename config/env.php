<?php

namespace Utils;

use Dotenv\Dotenv;
class Env
{


    public static function generateKey()
    { // Carga el archivo .env
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        $simbols = '!@#$%^&*()-_=+';
        $number = 1234685219;
        $word = $_ENV['API_JWT'];
        $key = $word . $number . $simbols;
        return $key;
    }
}
