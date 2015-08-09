<?php

namespace AppBundle\Encryptor;

/**
 * Allows user to encrypt/decrypt some data
 **/
class AES256Encryptor
{
    /** @var string */
    private $secretKey;

    /** @var string */
    private $initializationVector;

    /**
     * @param string $key
     */
    public function __construct($key)
    {
        $this->secretKey            = md5($key);
        $this->initializationVector = mcrypt_create_iv(
            mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB),
            MCRYPT_RAND
        );
    }

    /**
     * Returns encrypted data string
     *
     * @param string $data
     *
     * @return string
     */
    public function encrypt($data)
    {
        return trim(base64_encode(mcrypt_encrypt(
            MCRYPT_RIJNDAEL_256,
            $this->secretKey,
            $data,
            MCRYPT_MODE_ECB,
            $this->initializationVector
        )));
    }

    /**
     * Decrypts data
     *
     * @param string $data
     *
     * @return string
     */
    public function decrypt($data)
    {
        return trim(mcrypt_decrypt(
            MCRYPT_RIJNDAEL_256,
            $this->secretKey,
            base64_decode($data),
            MCRYPT_MODE_ECB,
            $this->initializationVector
        ));
    }

}
