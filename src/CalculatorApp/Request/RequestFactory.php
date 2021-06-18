<?php


namespace App\CalculatorApp\Request;


class RequestFactory
{
    public static function createRequestSchema($POST): IRequest
    {
        return new Request($POST);
    }
}
