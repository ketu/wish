<?php
/**
 * User: ketu.lai <ketu.lai@gmail.com>
 * Date: 2017/3/22 15:59
 */

namespace Veda\Wish;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Veda\Utils\Http\Uri;

class Auth
{
    const AUTHORIZATION_ENDPOINT = 'https://sandbox.merchant.wish.com/authorize';
    const TOKEN_REQUEST_ENDPOINT = 'https://sandbox.merchant.wish.com/api/v2/oauth/access_token';

    const ACCESS_TOKEN_BY_AUTHORIZE_CODE = 'authorization_code';
    const ACCESS_TOKEN_BY_REFRESH_CODE = 'refresh_token';

    protected $clientId;
    protected $clientSecret;

    protected $redirectUri;
    protected $redirectState;

    public function __construct($clientId, $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param mixed $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @return mixed
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * @param mixed $clientSecret
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    /**
     * @return mixed
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * @param mixed $redirectUri
     */
    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;
    }

    /**
     * @return mixed
     */
    public function getRedirectState()
    {
        return $this->redirectState;
    }

    /**
     * @param mixed $redirectState
     */
    public function setRedirectState($redirectState)
    {
        $this->redirectState = $redirectState;
    }

    /**
     * @return string
     */
    public function getAuthorizationUrl()
    {
        $uri = Uri::fromString(self::AUTHORIZATION_ENDPOINT);

        $query = [
            'client_id' => $this->getClientId()
        ];
        $uri->withQuery($query);

        return  $uri->__toString();
    }

    /**
     * @param $code
     * @param $codeType
     * @return array|mixed
     */
    public function getAccessToken($code, $codeType)
    {
        if (!in_array($codeType, [self::ACCESS_TOKEN_BY_AUTHORIZE_CODE, self::ACCESS_TOKEN_BY_REFRESH_CODE])) {
            throw new \InvalidArgumentException('grant_type can not be recognized ');
        }

        $tokenData = [];
        try {
            $client = new Client();
            $response = $client->post(self::TOKEN_REQUEST_ENDPOINT, [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode(sprintf("%s:%s", [
                            $this->getClientId(), $this->getClientSecret()
                        ]))
                ],
                'form_params' => [
                    'grant_type' => $codeType,
                    'code' => $code,
                    'redirect_uri' => $this->getRedirectUri()
                ]
            ]);
            if ($response->getStatusCode()) {
                $tokenData = \json_decode($response->getBody());
            }
            return $tokenData;
        } catch (ClientException $e) {
            // throw custom exception
        }
    }

    public function getRefreshToken($refreshCode) {
       /* POST https://merchant.wish.com/api/v2/oauth/refresh_token
        Parameters
        client_id	Your app's client ID
        client_secret	Your app's client secret
        refresh_token	Your refresh token
        grant_type	The string 'refresh_token'*/
    }
}