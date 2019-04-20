<?php
	return [
		'configs' => [

		],

		/*
		|--------------------------------------------------------------------------
		| Providers
		|--------------------------------------------------------------------------
		|
		| Don't forget to set this env file.
		| You can add providers to load in app
		|
		| Global: register the key service providers for the app
		| Production: register service providers only if the development environment is production
		| Staging: register service providers only if the development environment is staging
		| Develop: register service providers only if the development environment is develop
		|
		*/
		'providers' => [
			'default' => true,

			'global' => [
				'core' => \Cosmo\Core\Providers\ServicesProvider::class,
				'auth' => \Cosmo\Auth\AuthServiceProvider::class,
				'response' => \ServiceResponse\Laravel\Providers\ResponseServiceProvider::class,
				'cache' => \CacheSystem\CacheServiceProvider::class,
				'front-manager' => \FrontManager\Providers\FrontManagerServiceProvider::class,

				'app' => App\Providers\AppServiceProvider::class,
			],

			'production' => [
				//
			],

			'staging' => [
				//
			],

			'develop' => [
				//
			]
		],

		/*
		|--------------------------------------------------------------------------
		| Load Alias and Middleware
		|--------------------------------------------------------------------------
		|
		| Alias: create alias of class ('aliasName' => PathClass::class)
		| Middlewares: register middleware for all application routes (PathClass::class)
		| Route middlewares: register middleware in the application that can then be used to protect routes or/and controllers ( 'middlewareName' => PathClass::class)
		*/
		'alias' => [],

		'middlewares' => [
			\Cosmo\Core\Http\Middleware\CorsMiddleware::class
		],

		'route_middlewares' => [],

		/*
		|--------------------------------------------------------------------------
		| Set handler
		|--------------------------------------------------------------------------
		|
		| If you would use a Cosmo handler copy one of this
		| Lumen: \ServiceResponse\Laravel\Exceptions\LumenHandler::class,
		| Larvel: \ServiceResponse\Laravel\Exceptions\LaravelHandler::class,
		*/
		'handler' => \ServiceResponse\Laravel\Exceptions\LumenHandler::class,
	];