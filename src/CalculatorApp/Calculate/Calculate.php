<?php


namespace App\CalculatorApp\Calculate;

use App\CalculatorApp\Request\IRequest;
use App\CalculatorApp\Storage\IStorage;

class Calculate implements ICalculate
{
    public function RequestHandler($name, IRequest $request, IStorage $storage): String
    {

        $specialChars = ['C', '=', 'dot','divide'];

        if ($this->correctElem($name, $request, $storage)) {
             if ($request->get($name) == 'C') {
                $storage->clear();
            } elseif ($request->get($name) == '=') {
                $result = implode($this->calculate($name, $storage));
                $storage->setSession($name, $result);
            }
        }
        return $storage->getSession($name);
    }
    private function calculate($name, $storage): array
    {
        $equation = str_split($storage->getSession($name));


        while ($equation[0] == 0 && $equation[1] != '.' && isset($equation[1])) {
            array_shift($equation);
        }
        if (!is_numeric(end($equation))) {
            array_pop($equation);
        }
        $string = implode($equation);
        if (preg_match('/\/0\d*$|\+0\d*$|-0\d*$/', $string)) {
            $replacements = [
                '/\/0/' => '/',
                '/\+0/' => '+',
                '/-0/'  => '-',
            ];

            $equation = preg_replace(array_keys($replacements), array_values($replacements), $string);
            $equation = str_split($equation);
        }
        if (preg_match('/\/0*$|\+0*$|-0*$/', $string)) {
            $replacements = [
                '/\/0/' => '',
                '/\+0/' => '',
                '/-0/'  => '',
            ];

            $equation = preg_replace(array_keys($replacements), array_values($replacements), $string);
            $equation = str_split($equation);
        }

        $equation = implode('', $equation);
        return [strval(eval("return " . "$equation" . ';'))];
    }
    private function correctElem($name, IRequest $request, IStorage $storage): bool
    {
        if ($request->get($name) == 'C') {
            return true;
        }
        if ($request->get($name) == '=') {
            return true;
        }
        if ($request->get($name) == 'dot') {
            $request->set($name, '.');
        } elseif ($request->get($name) == 'divide') {
            $request->set($name, '/');
        }
        $secondZeroInARowRegex = '/\*0[0-9]$|\/0[0-9]$|-0[0-9]$|\+0[0-9]$/';
        $secondDotRegex = '/.*\.\d*\./';

        if ($request->get($name) == '.') {
            if (preg_match($secondDotRegex, ($storage->getSession($name) . $request->get($name))) == true) {
                return false;
            }
        }
        if (preg_match($secondZeroInARowRegex, ($storage->getSession($name) . $request->get($name))) == true) {
            return false;
        }
        if (is_numeric(substr($storage->getSession($name), -1)) == false) {
            if (is_numeric($request->get($name)) == true) {
                    $storage->add($name, $request->get($name));
                    return true;
            } else {
                return false;
            }
        } else {
            $storage->add($name, $request->get($name));
            return true;
        }
    }
}
