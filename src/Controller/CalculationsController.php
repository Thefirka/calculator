<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\CalculatorApp\Calculate\CalculateFactory;
use App\CalculatorApp\Request\RequestFactory;
use App\CalculatorApp\Storage\StorageFactory;
use Symfony\Component\HttpFoundation\Session\Session;

class CalculationsController extends AbstractController
{
    /**
     * @Route ("/{equation<[0-9]|divide|dot|=|C|\+|\-|\*>}", methods="POST", name="calculator_equation")
     */
    public function calculate($equation): JsonResponse
    {
        $calculate = CalculateFactory::createCalculator();
        $storage = StorageFactory::createStorageSession(new Session());
        $sessionName = $storage->getSessionName();
        $request = RequestFactory::createRequestSchema([$sessionName => $equation]);
        $equation = $calculate->requestHandler($request, $storage);
        return $this->json(['calculator' => $equation]);
    }
}