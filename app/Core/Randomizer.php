<?php


namespace App\Core;

/**
 * Class Randomizer
 *
 * @package App\Core
 */
class Randomizer
{
    /**
     * Gets random string with random number of letters
     *
     * @return string
     */
    public function getRandomString()
    {
        $str = rand();

        $string = md5($str);
        $string = substr($string, 0, rand(5, 10));

        return $string;
    }
}
