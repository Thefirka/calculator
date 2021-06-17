<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CalculatorController extends AbstractController
{
    private $post;
    /**
     * @Route("/", name="app_calculator")
     */
    public function calculator()
    {
        return $this->render('calculator/calculator.html.twig');
    }
}