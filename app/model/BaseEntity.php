<?php

abstract class BaseEntity extends \Nette\Database\Table\ActiveRow
{
    public function getNoPhoto()
    {
        return WWW_DIR. '/images/no_photo.png';
    }
}