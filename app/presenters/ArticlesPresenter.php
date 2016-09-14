<?php

namespace App\Presenters;

use App\Forms\ArticleFormFactory;
use App\Model\Articles;
use Nette\Application\UI\Form;

class ArticlesPresenter extends BasePresenter
{
    /** @var Articles @inject */
    public $articles;
    
    /** @var ArticleFormFactory @inject */
    public $articleFactory;

    /** @persistent */
    public $item;

    public function renderDefault()
    {
        if(!$this->user->isLoggedIn()){
            $this->flashMessage('You do not have access to this section', 'warning');
            $this->redirect('Homepage:');
        }
        $articles = $this->articles->findArticles();
        $this->template->articles = $articles;
    }

    public function renderEdit($id)
    {
        if(!$this->user->isLoggedIn()){
            $this->flashMessage('You do not have access to this section', 'warning');
            $this->redirect('Homepage:');
        }
        if(!empty($id)){
            $this->item = $this->articles->find($id);
            $this['editForm']->setDefaults($this->item);
            $this->template->item = $this->item;
        }
    }

    public function createComponentEditForm()
    {
        $form = $this->articleFactory->create();
        $form->onSubmit[] = function(Form $form){
            if($form->isSuccess()){
                $this->flashMessage('The article was successfully saved', 'success');
            }
        };
        return $form;
    }

    public function handleDeleteArticle($id){
        $this->articles->find($id)->update(array('deleted' => 1));
    }

}