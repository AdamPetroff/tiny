<?php

namespace App\Model;

use Nette;

class Articles extends Base
{
    public $table_name = 'articles';
    
    public function findArticles()
    {
        return $this->database->table('articles')->where('deleted = ?', 0);
    }
}