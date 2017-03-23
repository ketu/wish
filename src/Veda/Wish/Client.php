<?php
/**
 * User: ketu.lai <ketu.lai@gmail.com>
 * Date: 2017/3/22 15:59
 */

namespace Veda\Wish;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use Veda\Wish\Request\RequestAbstract;
use Veda\Utils\Http\Uri;

class Client
{

    private $httpClient;
    protected $request;


    public function __construct(RequestAbstract $request)
    {
        $this->request = $request;
    }

    /**
     * @return RequestAbstract
     */
    public function getRequest(): RequestAbstract
    {
        return $this->request;
    }

    /**
     * @param RequestAbstract $request
     */
    public function setRequest(RequestAbstract $request)
    {
        $this->request = $request;
    }



    private function buildUri()
    {
        $apiEndpoint = $this->getRequest()->getConfig()->getApiEndpoint();
        $actionEndpoint = $this->getRequest()->getEndpoint();
        $uri = Uri::fromString($apiEndpoint);
        return $uri->withPath($actionEndpoint);

    }

    private function buildParams()
    {
        if ($this->getRequest()->getMethod() == RequestAbstract::HTTP_METHOD_GET){
            return ['query'=> $this->getRequest()->getParameters()];
        } elseif ($this->getRequest()->getMethod() == RequestAbstract::HTTP_METHOD_POST) {
            return ['form_params'=> $this->getRequest()->getParameters()];
        }
        return [];
    }

    private function buildHeaders()
    {
        $accessToken = $this->getRequest()->getConfig()->getAccessToken();

        return [
            'Authorization'=> "Bearer {$accessToken}"
        ];
    }

    public function send(RequestAbstract $request = null)
    {
        try {
            $method = $this->getRequest()->getMethod();
            $uri = $this->buildUri();
            $client = new HttpClient();
            $postOptions = [
                'headers'=> $this->buildHeaders()
            ];
            $postOptions = array_merge($this->buildParams(), $postOptions);
            $response = $client->request($method, $uri, $postOptions);
            if ($response->getStatusCode()) {
                return \json_decode($response->getBody(), true);
            }
            throw new \Exception('error');

        } catch (ClientException $e) {
            throw new \Exception($e->getMessage());
            // throw custom exception
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}