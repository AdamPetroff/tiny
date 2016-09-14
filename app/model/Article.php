<?php

class Article extends BaseEntity
{
    public function getImage()
    {
        if(!empty($this->img)){
            $path = WWW_DIR . '/images/articles/' . $this->id . '/' . $this->img;
            if(file_exists($path)){
                return $path;
            }
            else{
                return $this->getNoPhoto();
            }
        }
        else{
            return $this->getNoPhoto();
        }
    }
}