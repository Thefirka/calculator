<?php


namespace App\CalculatorApp\Calculate;


use App\CalculatorApp\Request\IRequest;
use App\CalculatorApp\Storage\IStorage;

interface ICalculate
{
    public function requestHandler(IRequest $request, IStorage $storage);
}
