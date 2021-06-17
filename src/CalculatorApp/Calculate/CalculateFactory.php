<?php


namespace App\CalculatorApp\Calculate;


class CalculateFactory
{
    public static function createCalculator(): ICalculate
    {
        return new Calculate();
    }
}
