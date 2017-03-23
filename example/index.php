<?php
/**
 * User: ketu.lai <ketu.lai@gmail.com>
 * Date: 2017/3/22 16:24
 */

require '../vendor/autoload.php';

require 'config.php';

$auth = new \Veda\Wish\Auth($clientId, $clientSecret);

// $auth->getAuthorizationUrl();
/*
try {
    $response = $auth->getAccessToken('914cf9af894240928e80421079df53f4', \Veda\Wish\Auth::ACCESS_TOKEN_BY_AUTHORIZE_CODE);

    var_dump($response);
}catch (\Exception $e) {
    echo $e->getMessage();
}

$accessToken = '';
try {
    $response = $auth->getAccessToken($refreshCode, \Veda\Wish\Auth::ACCESS_TOKEN_BY_REFRESH_CODE);
    $accessToken = $response['access_token'];
}catch (\Exception $e) {
    echo $e->getMessage();
}
*/
try {
    $config = new \Veda\Wish\Config($accessToken);
    $request = new \Veda\Wish\Request\Product\Retrieve($config);
    $request->setParentSku('sku');
    $client = new \Veda\Wish\Client($request);
    $response = $client->send();
} catch (\Exception $e) {
    echo $e->getMessage();
}