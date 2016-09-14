<?php

namespace App\Presenters;

use Nette;
use App\Forms\SignFormFactory;
use App\Forms\RegisterFormFactory;


class SignPresenter extends BasePresenter
{
	/** @var SignFormFactory @inject */
	public $factory;
	/** @var RegisterFormFactory @inject */
	public $registerFactory;

	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = $this->factory->create();
		$form->onSuccess[] = function ($form) {
			$this->redirect('Homepage:');
		};
		return $form;
	}
	protected function createComponentRegisterForm()
	{
		$registerForm = $this->registerFactory->create();
		$registerForm->onSuccess[] = function () {
			$this->flashMessage('YOu have been successfully registered. you can sign in now.', 'success');
			$this->redirect('Sign:in');
		};
		return $registerForm;
	}

	public function actionOut()
	{
		$this->getUser()->logout();
		$this->template->user = $this->getUser();
	}
	public function renderIn()
	{
		$this->template->user = $this->getUser();
	}
	public function renderUp()
	{
		$this->template->user = $this->getUser();
	}

}
