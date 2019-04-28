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
     * @var \Kosmosx\Support\Api\ApiService
     */
    public $api;

    /**
     * @var \Kosmosx\Auth\AuthService
     */
    public $auth;

    /**
     * @var \Kosmosx\Cache\Services\CacheBuilder
     */
    public $cache;

	/**
	 * @var \Kosmosx\Frontend\Factory\ManagerFactory
	 */
    public $manager;

	/**
	 * @var \Kosmosx\Response\Factory\FactoryResponse
	 */
    public $response;

    public function __construct()
    {
        $this->api = $this->resolve('service.api');
        $this->auth = $this->resolve('service.auth');
        $this->cache = $this->resolve('service.cache.builder');
        $this->manager = $this->resolve('factory.manager');
        $this->response = $this->resolve('factory.response');
    }

	/**
	 * Resolve instance
	 *
	 * @param string $class
	 * @param array $parameters
	 * @return \Laravel\Lumen\Application|mixed|null
	 */
    private function resolve(string $class, array $parameters = []) {
    	try {
    		return app($class,$parameters);
		} catch (\Exception $e){
			return null; //@TODO return null object
		}
	}
}