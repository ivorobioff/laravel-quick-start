<?php
namespace ImmediateSolutions\Support\Api\Verify;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface VerifiableInterface
{
    const NOT_FOUND = 'The requested resource has not been found';

    /**
     * @return bool
     */
    public function shouldVerify();
}