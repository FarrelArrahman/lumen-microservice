<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 25/07/18
	 * Time: 21.23
	 */

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;
	use ResponseHTTP\Response\Traits\ModelREST;

	class Example extends Model
	{
		use ModelREST;
	}
