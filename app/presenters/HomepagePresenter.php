<?php

namespace App\Presenters;

use App\Model\Articles;

class HomepagePresenter extends BasePresenter
{

    /** @var Articles @inject */
    public $articles;
    
    public $item;

    public function renderDefault()
    {
        $articles = $this->articles->findArticles();
        if(!$this->getUser()->isLoggedIn()){
            $articles->where('logged_in_only = ?', 0);
        }
        $this->template->articles = $articles;
    }

    public function renderDetail($id)
    {
        $this->item = $this->articles->find($id);
        $this->template->item = $this->item;
    }
    
}