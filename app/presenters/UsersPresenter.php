<?php

namespace App\Presenters;

use App\Forms\RegisterFormFactory;
use Nette;
use App\Model\Users;
use Nette\Security\User;
use App\Forms\FilterFormFactory;

class UsersPresenter extends BasePresenter
{
	public $users;
	public $factory;
	public $registerFactory;
	

	public function __construct(Users $users, RegisterFormFactory $registerFactory)
	{
		parent::__construct();
		$this->users = $users;
		$this->registerFactory = $registerFactory;
	}
	

	public function renderDefault()
	{
		$user = $this->getUser();
		if(!$user->isLoggedIn()){
			$this->flashMessage('You do not have access to this section', 'warning');
			$this->redirect('Homepage:');
		}
		
		$this->template->users = $this->users->findUsers();
	}

	public function createComponentRegisterForm(){
		$form = $this->registerFactory->create();
		$form->onSuccess[] = function($form){
			$this->flashMessage('New user has been added successfully', 'success');
			$this->redirect('Users:default');
		};
		return $form;
	}

}