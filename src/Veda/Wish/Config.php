<?php
/**
 * User: ketu.lai <ketu.lai@gmail.com>
 * Date: 2017/3/22 15:59
 */

namespace Veda\Wish;

class Config
{

    protected $accessToken;

    protected $apiEndpoint = 'https://sandbox.merchant.wish.com';

    protected $apiEndpointVersion = 'api/v2/';


    public function __construct($accessToken, $apiEndpoint = null)
    {
        $this->accessToken = $accessToken;
        if ($apiEndpoint) {
            $this->apiEndpoint = $apiEndpoint;
        }
    }

    /**
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param mixed $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return null|string
     */
    public function getApiEndpoint()
    {
        return $this->apiEndpoint;
    }

    /**
     * @param null|string $apiEndpoint
     */
    public function setApiEndpoint($apiEndpoint)
    {
        $this->apiEndpoint = $apiEndpoint;
    }

    /**
     * @return string
     */
    public function getApiEndpointVersion(): string
    {
        return $this->apiEndpointVersion;
    }

    /**
     * @param string $apiEndpointVersion
     */
    public function setApiEndpointVersion(string $apiEndpointVersion)
    {
        $this->apiEndpointVersion = $apiEndpointVersion;
    }
}
