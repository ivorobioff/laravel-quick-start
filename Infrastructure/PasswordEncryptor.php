<?php
namespace ImmediateSolutions\Support\Infrastructure;
use ImmediateSolutions\Support\Core\Interfaces\PasswordEncryptorInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class PasswordEncryptor implements PasswordEncryptorInterface
{
    /**
     * @param string $password
     * @return string
     */
    public function encrypt($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     *
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public function verify($password, $hash)
    {
        return password_verify($password, $hash);
    }
}