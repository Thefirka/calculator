<?php


namespace App\CalculatorApp\Request;


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
