<?php

/*
 * Component to generate different cases are strings, numbers, sequences
 */

class RandomGenerator
{
    /* 
    * Salt generator
    */
    public static function generateSalt($randomLength = false, $saltLength = 3)
    {
        $salt = '';

        if($randomLength)
                $length = rand(3,16); // lenght salt (from 3 to 16)
        else
                $length = $saltLength;

        for($i=0; $i<$length; $i++)                
                $salt .= chr(rand(97,122)); // chars from ASCII-table

        return $salt;            
    }

    /* 
    * Hash random generator
    */
    public static function generateRandomHash()
    {
        return str_shuffle(md5(time().rand(0,1000).rand(1000,10000).rand(10000,100000)));
    }        
}
