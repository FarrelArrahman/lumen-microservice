<?php
	return [
		/*
		|--------------------------------------------------------------------------
		| Providers
		|--------------------------------------------------------------------------
		|
		| Providers to register in app (lumen or laravel)
		|
		*/
		'providers' => Folklore\GraphQL\LumenServiceProvider::class,

		/*
		|--------------------------------------------------------------------------
		| Model and Contracts
		|--------------------------------------------------------------------------
		|
		| Model: load Type graphQL ('name' => PathClass::class)
		| Contracts: load Contracts type of graphQL ('name' => PathClass::class)
		|
		 */
		'model' => [
			'User' => App\Http\GraphQL\Type\User\UserType::class,
			'UserWithPost' => App\Http\GraphQL\Type\User\UserWithPostType::class,
			'UserPagination' => App\Http\GraphQL\Type\User\UserPaginationType::class,
			'Post' =>  App\Http\GraphQL\Type\Post\PostType::class,
			'PostWithUser' => App\Http\GraphQL\Type\Post\PostWithUserType::class,
			'PostPagination' =>  App\Http\GraphQL\Type\Post\PostPaginationType::class,
		],

		'contracts' => [
			'PaginationMeta' =>  Core\Http\GraphQL\Type\PaginationMetaType::class,
			'Timestamp' =>  Core\Http\GraphQL\Type\TimestampType::class,
		],
	];