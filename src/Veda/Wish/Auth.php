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

    const AUTHORIZATION_ENDPOINT = 'https://sandbox.merchant.wish.com/oauth/authorize';
    const TOKEN_REQUEST_BY_AUTHORIZATION_CODE_ENDPOINT = 'https://sandbox.merchant.wish.com/api/v2/oauth/access_token';
    const TOKEN_REQUEST_BY_REFRESH_CODE_ENDPOINT = 'https://sandbox.merchant.wish.com/api/v2/oauth/refresh_token';


    // grant type
    const ACCESS_TOKEN_BY_AUTHORIZE_CODE = 'authorization_code';
    const ACCESS_TOKEN_BY_REFRESH_CODE = 'refresh_token';

    protected $clientId;
    protected $clientSecret;

    protected $redirectUri = 'https://127.0.0.1';
    protected $redirectState;

    public function __construct($clientId, $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * @return mixed
     */
    public function getClientId(): string
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
    public function getClientSecret(): string
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
    public function getRedirectUri(): string
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
    public function getRedirectState(): string
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
    public function getAuthorizationUrl(): string
    {
        $uri = Uri::fromString(self::AUTHORIZATION_ENDPOINT);

        $query = [
            'client_id' => $this->getClientId()
        ];

        return $uri->withQuery($query);

    }

    /**
     * @param $code
     * @param $codeType
     * @return array|mixed
     */
    public function getAccessToken($code, $codeType): array
    {
        if (!in_array($codeType, [self::ACCESS_TOKEN_BY_AUTHORIZE_CODE, self::ACCESS_TOKEN_BY_REFRESH_CODE])) {
            throw new \InvalidArgumentException('grant_type can not be recognized ');
        }

        $formParams = [
            'grant_type' => $codeType,
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
            'redirect_uri' => $this->getRedirectUri(),
            'code' => $code
        ];

        $endpoint = self::TOKEN_REQUEST_BY_AUTHORIZATION_CODE_ENDPOINT;

        if ($codeType == self::ACCESS_TOKEN_BY_REFRESH_CODE) {
            $endpoint = self::TOKEN_REQUEST_BY_REFRESH_CODE_ENDPOINT;
            $formParams['refresh_token'] = $code;
        }

        $tokenData = [];
        try {
            $client = new Client();
            $response = $client->post($endpoint, [
                'form_params' => $formParams
            ]);
            if ($response->getStatusCode()) {
                $tokenData = \json_decode($response->getBody(), true);
            }
            if (isset($tokenData['data'])) {
                return $tokenData['data'];
            }
            throw new \Exception('no token data return');
        } catch (ClientException $e) {
            throw new \Exception($e->getMessage());
            // throw custom exception
        }
    }
}