<?php
namespace App\Forms;

use Nette;
use Nette\Security\User;
use App\Model\UserManager;
use Nette\Security\Passwords;


class EditProfileFormFactory extends Nette\Object
{
	public $factory;

	public $user;

	public $manager;

	public function __construct(FormFactory $factory, User $user, UserManager $manager)
	{
		$this->factory = $factory;
		$this->user = $user;
		$this->manager = $manager;
	}

	public function create()
	{
		$data = $this->user->getIdentity()->getData();

		$form = $this->factory->create();

		$form->addText('username', 'Username:')->setDefaultValue($data['username'])->setRequired();

		$form->addPassword('newPassword', 'New password:');

		$form->addPassword('password', 'Your current password')
			->setRequired('Please enter your password to make changes to your account');

		$form->addSubmit('edit','Edit');

		$form->onSuccess[] = [$this, 'formSucceeded'];
		return $form;
	}

	public function formSucceeded(Nette\Application\UI\Form$form, $values)
	{
		$identityData = $this->user->getIdentity()->getData();
		if($this->manager->verifyPassword($identityData['id'], $values->password)){
			$array['username'] = $values->username;
			if($values->newPassword !== NULL)
				$array['password'] = $values->newPassword;
			else
				$array['password'] = $values->password;
			if($this->manager->update($this->user->getId(), $array)){
				$this->user->logout();
				$this->user->login($array['username'], $array['password']);
			}
		} else {
			$form->addError('The password you entered is incorrect');
			return;
		}
	}
}