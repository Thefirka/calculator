<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\CalculatorApp\Storage\StorageFactory;
use Symfony\Component\HttpFoundation\Session\Session;
class CalculatorController extends AbstractController
{
    /**
     * @Route("/", name="app_calculator")
     */
    public function calculator()
    {
        $session = StorageFactory::createStorageSession(new Session());
        $currentNumber = $session->getSession();
        return $this->render('calculator/calculator.html.twig', [
            'currentNumber' => $currentNumber,
        ]);
    }
}