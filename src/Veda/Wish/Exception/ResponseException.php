<?php
/**
 * User: ketu.lai <ketu.lai@gmail.com>
 * Date: 2017/3/23 13:31
 */

namespace Veda\Wish\Exception;

class ResponseException extends \Exception
{

    protected $response = null;

    public function __construct($message = "", $code = 0, \Exception $previous = null)
    {
        $response = $previous->getResponse();
        if ($response) {
            $this->response = $response;
            $body = \json_decode($response->getBody());
            $message = $body->message;
            $code = $body->code;
        }
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return null
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param null $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }


}