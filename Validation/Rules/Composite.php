<?php
namespace ImmediateSolutions\Support\Validation\Rules;

use ImmediateSolutions\Support\Validation\Binder;
use ImmediateSolutions\Support\Validation\Error;
use ImmediateSolutions\Support\Validation\Performer;
use ImmediateSolutions\Support\Validation\Source\ArraySourceHandler;
use ImmediateSolutions\Support\Validation\Source\ObjectSourceHandler;
use ImmediateSolutions\Support\Validation\SourceHandlerInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Composite extends AbstractRule
{
    /**
     * @var callable
     */
    private $inflator;

    public function __construct(callable $inflator)
    {
        $this->inflator = $inflator;
        $this->setIdentifier('dataset');
        $this->setMessage('The dataset is incorrect.');
    }

    /**
     * @param mixed $value
     * @return Error|null
     */
    public function check($value)
    {
        $binder = new Binder();

        call_user_func($this->inflator, $binder);

        $errors = (new Performer())->perform($binder, $this->getSourceHandler($value));

        if (count($errors) > 0){

            /**
             * @var Error[] $errors
             */
            foreach ($errors as $property => $error){
                $this->getError()->addExtra($property, $error);
            }

            return $this->getError();
        }

        return null;
    }

    /**
     * @param array|object $source
     * @return SourceHandlerInterface
     */
    protected function getSourceHandler($source)
    {
        if (is_array($source)){
            return new ArraySourceHandler($source);
        }

        return new ObjectSourceHandler($source);
    }
}