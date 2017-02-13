<?php
namespace ImmediateSolutions\Support\Validation;

use ImmediateSolutions\Support\Validation\Source\ArraySourceHandler;
use ImmediateSolutions\Support\Validation\Source\ObjectSourceHandler;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class AbstractThrowableValidator
{
    /**
     * @param Binder $binder
     * @return void
     */
    abstract protected function define(Binder $binder);

    /**
     * @param object|array $source
     * @param bool $soft
     * @throws ErrorsThrowableCollection
     */
    public function validate($source, $soft = false)
    {
        $errors = (new Performer())->perform($this->getBinder(), $this->getSourceHandler($source), $soft);

        if (count($errors) > 0) {
            throw $errors;
        }
    }

    /**
     * @return Binder
     */
    private function getBinder()
    {
        $binder = new Binder();
        $this->define($binder);
        return $binder;
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