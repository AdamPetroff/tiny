<?php
namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use App\Model\UserManager;

class RegisterFormFactory extends Nette\Object
{
	private $factory;

	private $manager;

	function __construct(FormFactory $form, UserManager $manager)
	{
		$this->factory = $form;
		$this->manager = $manager;
	}

	public function create()
	{
		$form = $this->factory->create();
		$form->addText('username','Username:')
			->setRequired('Please select an username');

		$form->addPassword('password','Password:')
			->setRequired('Please select a password');

		$form->addPassword('passwordVerify','Password again:')
			->setRequired('Please enter the password again')
			->addRule(Form::EQUAL, 'You entered two different passwords. Try again', $form['password']);

		$form->addSubmit('submit','Submit');

		$form->onSuccess[] = [$this,'formSucceeded'];
		return $form;
	}
	public function formSucceeded(Form $form, $values)
	{

		$this->manager->add($values->username, $values->password);
	}
}