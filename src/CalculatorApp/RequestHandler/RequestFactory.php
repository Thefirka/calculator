<?php


namespace App\CalculatorApp\RequestHandler;


class RequestFactory
{
    public static function createRequestSchema($POST): IRequest
    {
        return new Request($POST);
    }
}
