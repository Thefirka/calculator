<?php


namespace App\CalculatorApp\Calculate;


use App\CalculatorApp\RequestHandler\IRequest;
use App\CalculatorApp\Storage\IStorage;

interface ICalculate
{
    public function requestHandler($name, IRequest $request, IStorage $storage);
    public function calculate($name, IStorage $storage);
}
