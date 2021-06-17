<?php


namespace App\CalculatorApp\Storage;


use Symfony\Component\HttpFoundation\Session\Session;

interface IStorage
{
    public function add($name, $value);
    public function all(): Session;
    public function clear();
    public function getSession($name);
}
