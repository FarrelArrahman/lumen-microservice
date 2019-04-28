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
				'core' => \Kosmosx\Framework\Core\Providers\ServicesProvider::class,
				'auth' => \Kosmosx\Auth\AuthServiceProvider::class,
				'response' => \Kosmosx\Response\Laravel\Providers\ResponseServiceProvider::class,
				'cache' => \Kosmosx\Cache\CacheServiceProvider::class,
				'frontend' => \Kosmosx\Frontend\Providers\FrontendServiceProvider::class,

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
			\Kosmosx\Auth\Middleware\CorsMiddleware::class
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
		'handler' => \Kosmosx\Response\Laravel\Exceptions\LumenHandler::class,
	];