<?php
/**
 * Created by PhpStorm.
 * User: fabrizio
 * Date: 29/11/18
 * Time: 23.59
 */

namespace App\Http\Controller\RESTful;

use Laravel\Lumen\Routing\Controller as BaseController;
use ResponseHTTP\Response\HttpResponse;

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

    public function __construct()
    {
        $this->api = app('service.api');
        $this->auth = app('service.auth');
        $this->cache = app('service.cache.builder');
        $this->manager = app('factory.manager');
    }

    /**
     *   Helper function to create Response http
     *
     * @param null $content
     * @param int $status
     * @param array $headers
     * @param bool $json
     *
     * @return \ResponseHTTP\Response\HttpResponse
     */
    public function response($content = null, int $status = 200, array $headers = array(), bool $json = false)
    {
        return new HttpResponse($content, $status, $headers, $json);
    }
}