<?php
/**
 * User: ketu.lai <ketu.lai@gmail.com>
 * Date: 2017/3/22 16:24
 */

require '../vendor/autoload.php';

require 'config.php';

$auth = new \Veda\Wish\Auth($clientId, $clientSecret);

// $auth->getAuthorizationUrl();

/*try {
    $response = $auth->getAccessToken('914cf9af894240928e80421079df53f4', \Veda\Wish\Auth::ACCESS_TOKEN_BY_AUTHORIZE_CODE);

    var_dump($response);
}catch (\Exception $e) {
    //echo $e->getMessage();
     var_dump(\json_decode($e->getResponse()->getBody(), true));
}*/

/*
$accessToken = '';
try {
    $response = $auth->getAccessToken($refreshCode, \Veda\Wish\Auth::ACCESS_TOKEN_BY_REFRESH_CODE);
    echo $accessToken = $response->access_token;
}catch (\Exception $e) {
    echo $e->getMessage();
}*/
$accessToken = 'dce38bb2107d4352bc901cd6d164c383';


try {
    $config = new \Veda\Wish\Config($accessToken);
    $request = new \Veda\Wish\Request\Product\Retrieve($config);
    $request->setParentSku('SKU-MK-001');
    $client = new \Veda\Wish\Client($request);
    $response = $client->send();

    var_dump($response);
} catch (\Veda\Wish\Exception\ResponseException $e) {
    var_dump($e->getMessage());
} catch (\Exception $e) {
    echo $e->getMessage();
}
