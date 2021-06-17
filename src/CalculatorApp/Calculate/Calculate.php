<?php


namespace App\CalculatorApp\Calculate;

use App\CalculatorApp\Storage\IStorage;

class Calculate implements ICalculate
{
    public function RequestHandler($name, $request, $storage): bool
    {
        $specialChars = ['C', '=', 'dot','divide'];

        if ($this->correctElem($name, $request->get($name), $storage)) {
            if (in_array($request->get($name), $specialChars) != true) {
                $storage->add($name, $request->get($name));
            } elseif ($request->get($name) == 'C') {
                $storage->clear();
            } elseif ($request->get($name) == '=') {

            } elseif ($request->get($name) == 'dot') {
                if (preg_match('/.*\.\d*\./', implode('', $_SESSION[$name]) . '.') <= 0) {
                    $storage->add($name, $request->get($name));
                }
            } elseif ($request->get($name) == 'divide') {
                $storage->add($name, '/');
            } else {
                return false;
            }

        } else {
            return false;
        }
    }
    public function calculate($name, $storage): array
    {
        $session = $storage->getSession($name);

        while ($session[0] == 0 && $session[1] != '.' && isset($session[1])) {
            array_shift($session);
        }
        if (!is_numeric(end($session))) {
            array_pop($session);
        }

        $string = implode($session);
        if (preg_match('/\*0\d*$|\/0\d*$|\+0\d*$|-0\d*$/', $string)) {
            $replacements = [
                '/\*0/' => '*',
                '/\/0/' => '/',
                '/\+0/' => '+',
                '/-0/'  => '-',
            ];

            $session = preg_replace(array_keys($replacements), array_values($replacements), $string);
            $session = str_split($session);
        }
        if (preg_match('/\*0*$|\/0*$|\+0*$|-0*$/', $string)) {
            $replacements = [
                '/\*0/' => '',
                '/\/0/' => '',
                '/\+0/' => '',
                '/-0/'  => '',
            ];

            $session = preg_replace(array_keys($replacements), array_values($replacements), $string);
            $session = str_split($session);
        }
        $equation = implode('', $session);
        return [strval(eval("return " . "$equation" . ';'))];
    }
    private function correctElem($sessionName, $newElement, IStorage $storage): bool
    {
        $IncorrectElemRegex = '/\*00$|\/00$|\+00$|-00$/';
        $findAnyLetterRegex = '/^\p{L}+$/';


    }
}
