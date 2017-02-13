<?php
namespace ImmediateSolutions\Support\Api\Validation\Rules;

use ImmediateSolutions\Support\Validation\Rules\Combine;
use ImmediateSolutions\Support\Validation\Rules\IntegerCast;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DocumentMixedIdentifier extends Combine
{
    public function __construct()
    {
        parent::__construct([
            new IntegerCast(),
            new DocumentHashIdentifier()
        ]);

        $this->setIdentifier('cast');
        $this->setMessage('The document identifier must be int or hash consisting of id and token.');
    }
}