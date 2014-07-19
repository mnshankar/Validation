<?php

namespace spec\mnshankar\Validation;

use mnshankar\Validation\FactoryInterface;
use mnshankar\Validation\ValidatorInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FormValidatorSpec extends ObjectBehavior
{
	function let(FactoryInterface $validatorFactory)
	{
		$this->beAnInstanceOf('spec\mnshankar\Validation\ExampleValidator');
		$this->beConstructedWith($validatorFactory);
	}

	function it_validates_a_set_of_valid_data(FactoryInterface $validatorFactory, ValidatorInterface $validator)
	{
		$fakeFormData = array('username' => 'joe');

		$validatorFactory->make($fakeFormData, $this->getValidationRules(), array())->willReturn($validator);
		$validator->fails()->willReturn(false);

		$this->validate($fakeFormData)->shouldReturn(true);
	}

	function it_throws_an_exception_for_invalid_form_data(FactoryInterface $validatorFactory, ValidatorInterface $validator)
	{
		$fakeFormData = array('username' => '');

		$validatorFactory->make($fakeFormData, $this->getValidationRules(), array())->willReturn($validator);
		$validator->fails()->willReturn(true);
		$validator->errors()->willReturn(array());

		$this->shouldThrow('mnshankar\Validation\FormValidationException')->duringValidate($fakeFormData);
	}
}

class ExampleValidator extends \mnshankar\Validation\FormValidator {
	protected $rules = array('username' => 'required');
}
