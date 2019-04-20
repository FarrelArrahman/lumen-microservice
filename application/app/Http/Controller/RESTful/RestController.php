<?php
/**
 * Created by PhpStorm.
 * User: fabrizio
 * Date: 29/11/18
 * Time: 23.59
 */

namespace App\Http\Controller\RESTful;

use Laravel\Lumen\Routing\Controller as BaseController;
use ServiceResponse\Response\FactoryServiceResponse;

class RestController extends BaseController
{
    /**
     * @var \Cosmo\Api\ApiService
     */
    public $api;

    /**
     * @var \Cosmo\Auth\AuthService
     */
    public $auth;

    /**
     * @var \CacheSystem\Services\CacheBuilder
     */
    public $cache;

	/**
	 * @var \FrontManager\Factory\ManagerFactory
	 */
    public $manager;

	/**
	 * @var \ServiceResponse\Response\Factory\FactoryServiceResponse
	 */
    public $response;

    public function __construct()
    {
        $this->api = app('service.api');
        $this->auth = app('service.auth');
        $this->cache = app('service.cache.builder');
        $this->manager = app('factory.manager');
        $this->response = app('factory.response');
    }
}