<?php
namespace App\Traits;

trait RandomStringTrait
{
    /**
     * Keyspace for random generator
     * @var string
     */
    private $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * Random string length
     * @var integer
     */
    private $strLength = 32;

    /**
     * Generates random string with length $stringLength from the given keyspace $keyspace
     * @return string random string
     */
    public function randomString()
    {
        $pieces = [];
        $max = mb_strlen($this->keyspace, '8bit') - 1;
        for ($i = 0; $i < $this->strLength; ++$i) {
            $pieces[] = $this->keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    /**
     * Setter for $strLength
     * @param integer $length
     */
    public function setStrLength($length)
    {
        $this->strLength = $length;
    }

    /**
     * Setter for $keyspace;
     * @param string $space string
     */
    public function setKeyspace($space)
    {
        $this->keyspace = $space;
    }
}
