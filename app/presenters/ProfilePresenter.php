<?php

namespace App\Presenters;

use Nette;
use Nette\Security\User;
use App\Model\UserManager;
use App\Forms\EditProfileFormFactory;

class ProfilePresenter extends BasePresenter
{
	public $factory;

	public $manager;

	public function __construct(UserManager $manager, EditProfileFormFactory $factory)
	{
		$this->factory = $factory;
		$this->manager = $manager;
	}

	public function renderDefault()
	{
		$this->template->userData = $this->getUser()->getIdentity()->getData();
		$this->template->user = $this->getUser();

	}

	public function renderEdit()
	{
	$this->template->user = $this->getUser();
	}

	public function createComponentEditProfileForm()
	{
		$form = $this->factory->create();
		$form->onSuccess[] = function($form){
			$this->flashMessage('Success!');
			$this->setView('default');
		};
		return $form;
	}
}