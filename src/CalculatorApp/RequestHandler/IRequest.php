<?php


namespace App\CalculatorApp\RequestHandler;


interface IRequest
{
    /**
     * @param $name
     *
     * @return mixed
     */
    public function get($name);
    public function set($name, $value): IRequest;

}
