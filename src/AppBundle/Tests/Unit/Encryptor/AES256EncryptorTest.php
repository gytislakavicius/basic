<?php

namespace AppBundle\Tests\Unit\Encryptor;

use AppBundle\Encryptor\AES256Encryptor;

/**
 * Unit test for AES256Encryptor
 **/
class AES256EncryptorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test data provider for testEncryption
     *
     * @return array
     */
    public function getTestEncryptionData()
    {
        $cases = [];

        // case 0: empty string
        $cases[] = [''];

        // case 1: one liner
        $cases[] = ['text to be encoded'];

        // case 2: multi liner
        $cases[] = [<<<foo
text to be encoded
and one more line
foo
        ];

        // case 3: json
        $object = new \stdClass();
        $object->foo = new \stdClass();
        $object->foo->bar = "string";
        $object->bar = new \DateTime();

        $cases[] = [json_encode($object)];

        return $cases;
    }

    /**
     * @param $data
     *
     * @dataProvider getTestEncryptionData()
     */
    public function testEncryption($data)
    {
        $key = 'secret thingy ~!-=34žžčęė' . mt_rand();

        $encoder = new AES256Encryptor($key);

        $this->assertEquals(
            $data,
            $encoder->decrypt($encoder->encrypt($data))
        );
    }
}
