<?php
namespace ImmediateSolutions\Support\Validation\Rules;
use Illuminate\Http\UploadedFile;
use ImmediateSolutions\Support\Validation\Error;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Document extends AbstractRule
{
    /**
     * File constructor.
     */
    public function __construct()
    {
        $this->setIdentifier('document');
        $this->setMessage('Document is not attached.');
    }

    /**
     *
     * @param mixed $value
     * @return Error|null
     */
    public function check($value)
    {
        if (!$value instanceof UploadedFile) {
            return $this->getError();
        }

        return null;
    }
}