<?php
namespace ImmediateSolutions\Support\Infrastructure;
use ImmediateSolutions\Support\Core\Interfaces\TokenGeneratorInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class TokenGenerator implements TokenGeneratorInterface
{
    /**
     * @return string
     */
    public function generate()
    {
        return md5(uniqid(rand(), true));
    }
}