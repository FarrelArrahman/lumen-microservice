<?php

	return [
		'path' => 'App\Http\Controller\RESTful',
		'resources' => [
			'v1' => [
				'ExampleController' => [
					'endpoint' => 'api/v1/test',
				],
			]
		],
	];