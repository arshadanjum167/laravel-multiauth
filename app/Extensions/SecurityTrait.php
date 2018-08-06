<?php
namespace App\Extensions;

trait  SecurityTrait {
    
    public function generateRandomKey($length = 32)
    {
   
        if (function_exists('random_bytes')) {
            return mb_convert_encoding(random_bytes($length), 'UTF-8', 'UTF-8');
            // return random_bytes($length);
        }
        
    
    if (!is_int($length)) {
        throw new InvalidParamException('First parameter ($length) must be an integer');
    }

    if ($length < 1) {
        throw new InvalidParamException('First parameter ($length) must be greater than 0');
    }

    throw new Exception('Unable to generate a random key');
    }

/**
 * Generates a random string of specified length.
 * The string generated matches [A-Za-z0-9_-]+ and is transparent to URL-encoding.
 *
 * @param integer $length the length of the key in characters
 * @return string the generated random key
 * @throws Exception on failure.
 */
public  function generateRandomString($length = 32)
{
    if (!is_int($length)) {
        throw new InvalidParamException('First parameter ($length) must be an integer');
    }

    if ($length < 1) {
        throw new InvalidParamException('First parameter ($length) must be greater than 0');
    }

    $bytes = $this->generateRandomKey($length);
    // '=' character(s) returned by base64_encode() are always discarded because
    // they are guaranteed to be after position $length in the base64_encode() output.
    return strtr(substr(base64_encode($bytes), 0, $length), '+/', '_-');
}

    public function byteLength($string)
    {
        return mb_strlen($string, '8bit');
    }
}