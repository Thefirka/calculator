<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\CalculatorApp\Calculate\CalculateFactory;
use App\CalculatorApp\RequestHandler\RequestFactory;
use App\CalculatorApp\Storage\StorageFactory;
use Symfony\Component\HttpFoundation\Session\Session;

class CalculationsController extends AbstractController
{
    /**
     * @Route ("/calculations/{symbol}", name="calculator_symbol")
     */
    public function calculate($symbol): JsonResponse
    {
        $calculate = CalculateFactory::createCalculator();
        $storage = StorageFactory::createStorageSession(new Session());
        dd($storage->getSession('session'));
        $requestHandler = RequestFactory::createRequestSchema(['1']);
        return $this->json(['symbol' => $symbol]);
    }
}