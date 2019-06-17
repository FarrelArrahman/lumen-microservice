<?php

	/**
	 * Sample of Authentication routes usage
	 *
	 * $router->group(['prefix' => 'api/v1'], function () use ($router) {
	 *      $router->group(['prefix' => '/auth'], function () use ($router) {
	 *          $router->post('login', 'RESTful\v1\AuthController@authenticate');
	 *          $router->post('register', 'RESTful\v1\AuthController@register');
	 *          $router->get('authenticated',  'RESTful\v1\AuthController@getAuthenticatedUser');
	 *          $router->get('invalidate', 'RESTful\v1\AuthController@invalidate');
	 *          $router->get('refresh','RESTful\v1\AuthController@refresh');
	 *      });
	 * });
	 *
	 */
	$router->group(['prefix' => 'api/v1'], function () use ($router) {
		$router->get('discovery', function () {
			return Discovery::discovery('v1');
		});
		$router->get('test', 'RESTful\v1\ExampleController@test');
	});