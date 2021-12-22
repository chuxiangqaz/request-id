<?php

namespace XrequestID\Guzzle;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\RequestInterface;
use XRequestID\Conf;

class MiddleWare
{
    public static function withRequestID()
    {
        return addHeader(Conf::HEAD_ID, app(Conf::APP_ID));
    }

    public static function getHandlerStack()
    {
        $stack = new HandlerStack ();
        $stack->setHandler(new  CurlHandler ());
        $stack->push(self::withRequestID());
        return $stack;
    }
}


function addHeader($header, $value)
{
    return function (callable $handler) use ($header, $value) {
        return function (
            RequestInterface $request,
            array            $options
        ) use ($handler, $header, $value) {
            $request = $request->withHeader($header, $value);
            return $handler($request, $options);
        };
    };
}