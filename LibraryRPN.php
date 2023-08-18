<?php

namespace App;

use Exception as Exception;

/**
 * Class LibraryRPN
 */
class LibraryRPN
{
    private const MINUS = '-';
    private const PLUS = '+';
    private const DIVISION = '/';
    private const MULTIPLICATION = '*';
    private const EXPONENTIATION = '^';

    private const SEPARATOR = ' ';
    private const PATTERN_SYMBOLS = [self::MINUS, self::PLUS, self::DIVISION, self::MULTIPLICATION, self::EXPONENTIATION];

    private array $arrString = [];

    /**
     * @param string $str
     * @throws Exception
     */
    public function __construct(string $str)
    {
        self::setArrString($str);
    }

    /**
     * Переводи строку в массив
     * @throws Exception
     */
    private function setArrString(string $str): void
    {
        $this->arrString = explode(self::SEPARATOR, $str);
        if (count($this->arrString) < 1) {
            throw new Exception("Неверное выражение");
        }
    }

    /**
     * Возвращает результат калькуляци в FLOAT
     * @throws Exception
     */
    public function getResult(): float
    {
        $stack = [];
        foreach ($this->arrString as $item) {
            if (is_numeric($item)) {
                $stack[] = $item;
            } elseif (in_array($item, self::PATTERN_SYMBOLS)) {
                $right = array_pop($stack) ?? null;
                $left = array_pop($stack) ?? null;
                if ($right === null || $left === null) {
                    throw new Exception('Неверное выражение!');
                }

                $stack[] = $this->calc($left, $right, $item);
            } else {
                throw new Exception('Найден недопустимый символ');
            }
        }
        return $stack[0];
    }

    /**
     * Метод калькулирует входные параметры
     * @throws Exception
     */
    private function calc($left, $right, $operator)
    {
        switch ($operator) {
            case self::MINUS:
                return $left - $right;
            case self::PLUS:
                return $left + $right;
            case self::MULTIPLICATION:
                return $left * $right;
            case self::EXPONENTIATION:
                return $left ** $right;
            case self::DIVISION:
                if ($right == 0) {
                    throw new Exception('Деление на ноль!');
                }
                return $left / $right;
            default:
                throw new Exception('Неизвестный оператор ' . $operator);
        }
    }
}