<?php
/**
 * User: ketu.lai <ketu.lai@gmail.com>
 * Date: 2017/3/22 16:24
 */

require '../vendor/autoload.php';

require 'config.php';



$auth = new \Veda\Wish\Auth($clientId, $clientSecret);


echo $auth->getAuthorizationUrl();
