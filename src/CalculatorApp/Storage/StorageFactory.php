<?php


namespace App\CalculatorApp\Storage;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;

class StorageFactory
{
    public static function createStorageSession(Session $session): IStorage
    {
        return new Storage($session);
    }
}
