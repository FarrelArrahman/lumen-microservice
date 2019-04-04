<?php

	namespace App\Http\Controller\RESTful\v1;

	use App\Http\Controller\RESTful\RestController;

	class ExampleController extends RestController
	{
		public function test () {
		    return $this->response('Hello word', 200);
        }
	}
