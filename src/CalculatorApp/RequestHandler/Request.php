<?php


namespace App\CalculatorApp\RequestHandler;



class Request implements IRequest
{
    /**
     * @var array
     */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function get($name)
    {
        return array_key_exists($name, $this->data)
            ? $this->data[$name]
            : null;
    }

    public function set($name, $value): IRequest
    {
        $this->data[$name] = $value;

        return $this;
    }
}
