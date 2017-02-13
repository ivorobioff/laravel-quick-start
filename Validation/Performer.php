<?php
namespace ImmediateSolutions\Support\Validation;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Performer
{
	/**
	 * @param Binder $binder
	 * @param SourceHandlerInterface $source
	 * @param $soft
	 * @return ErrorsThrowableCollection
	 */
	public function perform(Binder $binder, SourceHandlerInterface $source, $soft = false)
	{
		$errors = new ErrorsThrowableCollection();

		/**
		 * @var Bundle $bundle
		 */
		foreach ($binder as list($bundle, $inflator)) {

			$constraint = $bundle->getConstraint();

			if ($constraint && !$constraint($source, $errors, $soft)){
				continue ;
			}

			if ($this->hasErrors($bundle, $errors)) {
				continue;
			}

			if ($soft && !$this->hasProperty($bundle, $source) && !$bundle->ignoreSoftness()) {
				continue;
			}

			$value = $this->getValue($bundle, $source);

			$property = new Property();
			$inflator($property);

			foreach ($property->getRules() as $rule){

				if ($value->isNull() && !$rule->isNullable()){
					continue ;
				}

				$error = $this->verify($rule, $value);

				if ($error){
					$errors[$bundle->getName()] = $error;
					break;
				}
			}
		}

		return $errors;
	}

	/**
	 * @param Bundle $bundle
	 * @param ErrorsThrowableCollection $errors
	 * @return bool
	 */
	private function hasErrors(Bundle $bundle, ErrorsThrowableCollection $errors)
	{
		foreach ($bundle as list($property)) {
			if (isset($errors[$property])) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @param RuleInterface $rule
	 * @param Value $value
	 * @return Error|null
	 */
	private function verify(RuleInterface $rule, Value $value)
	{
		if (count($value) > 1) {
			return $rule->check($value);
		}

		return $rule->check($value->first());
	}

	/**
	 * @param Bundle $bundle
	 * @param SourceHandlerInterface $source
	 * @return Value
	 */
	private function getValue(Bundle $bundle, SourceHandlerInterface $source)
	{
		$value = new Value();

		if ($bundle->getSource() !== null){
			$value->add(call_user_func($bundle->getSource()));
			return $value;
		}

		/**
		 * @var Force $force
		 */
		foreach ($bundle as list($property, $force)) {

			$sourceValue = $source->hasProperty($property) ? $source->getValue($property) : null;

			if ($force->is(Force::REQUIRED)) {
				$value->add($sourceValue);
			} else {
				$value->addOptional($sourceValue);
			}
		}

		return $value;
	}

	/**
	 * @param Bundle $bundle
	 * @param SourceHandlerInterface $source
	 * @return bool
	 */
	private function hasProperty(Bundle $bundle, SourceHandlerInterface $source)
	{
		if ($bundle->getSource() !== null){
			return true;
		}

		/**
		 * @var Force $force
		 */
		foreach ($bundle as list($property, $force)) {
			if ($force->is(Force::REQUIRED) && !$source->hasProperty($property)){
				return false;
			}
		}

		return true;
	}
}