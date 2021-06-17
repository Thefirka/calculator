<?php


namespace App\CalculatorApp\RequestHandler;



class Request implements IRequest
{
    /**
     * @var array
     */
    private $request;

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    public function get($name)
    {
        return array_key_exists($name, $this->request)
            ? $this->request[$name]
            : null;
    }

    public function set($name, $value): IRequest
    {
        $this->request[$name] = $value;

        return $this;
    }
}
