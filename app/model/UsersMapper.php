<?php 

namespace App\Model;

use Nette;

class Users extends Base
{
	public function findUsers($where = 1)
	{
		return $this->database->table('users')->where($where);
	}
}