<?php


namespace App\CalculatorApp\Storage;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
class Storage implements IStorage
{

    private $session;
    private $sessionName;
    public function add($name, $value) {
        $this->session->set($name, ($this->session->get($name) . $value));
    }
    public function __construct(Session $session)
    {
        $this->sessionName = 'session';
        $this->session = $session;
        $this->session->start();

    }
    public function all(): Session
    {
        return $this->session;
    }
    public function clear()
    {
        $this->session->clear();
    }
    public function getSession()
    {
       return $this->session->get($this->sessionName, '');
    }
    public function getSessionName()
    {
        return $this->sessionName;
    }

    public function setSession($name, $value)
    {
        $this->session->clear();
        $this->add($name, $value);
    }
}
