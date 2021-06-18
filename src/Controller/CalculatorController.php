<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\CalculatorApp\Storage\StorageFactory;
use Symfony\Component\HttpFoundation\Session\Session;
class CalculatorController extends AbstractController
{
    private $post;
    /**
     * @Route("/", name="app_calculator")
     */
    public function calculator()
    {
        $sessionName = 'session';                        //must be the same as $sessionName in CalculationsController.php
        $session = StorageFactory::createStorageSession(new Session());
        $currentNumber = $session->getSession($sessionName);
        if ($currentNumber == null) {
            $currentNumber = '';
            $session->add($sessionName, '');
        }
        return $this->render('calculator/calculator.html.twig', [
            'currentNumber' => $currentNumber,
        ]);
    }
}