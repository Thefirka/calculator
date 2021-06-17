<?php


namespace App\CalculatorApp\Calculate;

use App\CalculatorApp\Storage\IStorage;

class Calculate implements ICalculate
{
    public function RequestHandler($sessionName, $request, $storage): bool
    {
        $specialChars = ['C', '=', 'dot','divide'];
        if ($this->correctElem($sessionName, $request->get($sessionName), $storage)) {
            if (in_array($request->get($sessionName), $specialChars) != true) {
                $storage->add($sessionName, $request->get($sessionName));
            } elseif ($request->get($sessionName) == 'C') {
                $storage->clear();
            } elseif ($request->get($sessionName) == '=') {
                session_start();
                $_SESSION[$sessionName] = $this->calculate($sessionName, $storage);
                $storage->clear();
                $storage->add($sessionName, $_SESSION[$sessionName][0]);
            } elseif ($request->get($sessionName) == 'dot') {
                if (preg_match('/.*\.\d*\./', implode('', $_SESSION[$sessionName]) . '.') <= 0) {
                    $storage->add($sessionName, $request->get($sessionName));
                }
            } elseif ($request->get($sessionName) == 'divide') {
                $storage->add($sessionName, '/');
            } else {
                return false;
            }

        } else {
            return false;
        }
    }
    public function calculate($sessionName, $storage): array
    {
        $session = $storage->getSession($sessionName);

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
        $_SESSION[$sessionName] = [];
        return [strval(eval("return " . "$equation" . ';'))];
    }
    private function correctElem($sessionName, $newElement, IStorage $storage): bool
    {
        $IncorrectElemRegex = '/\*00$|\/00$|\+00$|-00$/';
        $findAnyLetterRegex = '/^\p{L}+$/';
        if ($newElement != 'C' && $newElement != '=') {
            if (!preg_match($findAnyLetterRegex, $newElement)) {
                $session = $storage->getSession($sessionName);
                if (preg_match($IncorrectElemRegex, implode('', $session) . $newElement)) {
                    return false;
                }
                $lastElem = end($session);
                if (!is_numeric($newElement)) {
                    if ($lastElem == null || is_numeric($lastElem) == false) {
                        return false;
                    }
                }
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }

    }
}
