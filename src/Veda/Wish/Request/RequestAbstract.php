<?php
/**
 * User: ketu.lai <ketu.lai@gmail.com>
 * Date: 2017/3/22 16:54
 */

namespace Veda\Wish\Request;


use Veda\Wish\Config;

abstract class RequestAbstract
{
    const HTTP_METHOD_GET = 'GET';
    const HTTP_METHOD_POST = 'POST';

    protected $config;

    protected $defaultRequestOptions = [];
    protected $requestParams = [];
    public $responseHandler;

    protected $endpoint;
    protected $method;

    public function __construct(Config $config, $responseHandler = null)
    {
        $this->config = $config;
        $this->responseHandler = $responseHandler;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getEndpoint()
    {
        return $this->getConfig()->getApiEndpointVersion() . $this->endpoint;
    }

    public function getMethod()
    {
        return $this->method;
    }

    protected function setParameter($key, $value)
    {
        $this->requestParams[$key] = $value;
    }

    protected function setParameters($parameters)
    {
        $this->requestParams = $parameters;
    }

    public function getParameters()
    {
        return $this->requestParams;
    }
}