<?php

namespace app\models;

use app\core\Model;

class Generator extends Model
{
    public $symbols;
    public $type;
    public $max_symbols = 3;

    public function generateCode(): string
    {
        $result = [];
        $symbolsArray = [];
        $symbolsCount = $this->symbols;

        $arrayNumbers = $this->arrayNumbers();
        $arrayBigLetters = $this->arrayBigLetters();
        $arraySmallLetters = $this->arraySmallLetters();

        if($this->isNumbers() && $this->isBigLetters() && $this->isSmallLetters()){
            $random_number_key = array_rand($arrayNumbers);
            $random_big_key = array_rand($arrayBigLetters);
            $random_small_key =  array_rand($arraySmallLetters);

            $result[] = $arrayNumbers[$random_number_key];
            $result[] = $arrayBigLetters[$random_big_key];
            $result[] = $arraySmallLetters[$random_small_key];

            unset($arrayNumbers[$random_number_key],
                  $arraySmallLetters[$random_small_key],
                  $arrayBigLetters[$random_big_key]);

            $symbolsCount -= 3;
        }

        if($this->isNumbers()){
            $symbolsArray = array_merge($symbolsArray, $arrayNumbers);
        }

        if($this->isBigLetters()){
            $symbolsArray = array_merge($symbolsArray, $arrayBigLetters);
        }

        if($this->isSmallLetters()){
            $symbolsArray = array_merge($symbolsArray, $arraySmallLetters);
        }
        if(count($symbolsArray)>0) {
            if ($symbolsCount == 1) {
                $result[] = $symbolsArray[array_rand($symbolsArray, $symbolsCount)];
            } else if ($symbolsCount > 1) {
                foreach (array_rand($symbolsArray, $symbolsCount) as $symbolKey) {
                    $result[] = $symbolsArray[$symbolKey];
                }
            }
            shuffle($result);
        }
        return implode("", $result);
    }

    public function countMaxSymbols(): void
    {
        if($this->isNumbers()){
            $this->max_symbols += count($this->arrayNumbers());
        }

        if($this->isSmallLetters()){
            $this->max_symbols += count($this->arraySmallLetters());
        }

        if($this->isBigLetters()){
            $this->max_symbols += count($this->arrayBigLetters());
        }
    }

    //big letters without "O"
    protected function arrayBigLetters(): array
    {
        return ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J',
                'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U',
                'V', 'W', 'X', 'Y', 'Z'];
    }

    //small letters without "l" and "o"
    protected function arraySmallLetters(): array
    {
        return ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j',
                'k', 'm', 'n', 'p', 'q', 'r', 's', 't', 'u',
                'v', 'w', 'x', 'y', 'z'];
    }

    protected function arrayNumbers(): array
    {
        return ['2', '3', '4', '5', '6', '7', '8', '9'];
    }

    protected function isNumbers()
    {
        return $this->type['numbers'] == '1';
    }

    protected function isSmallLetters()
    {
        return $this->type['small_letters'] == '1';
    }

    protected function isBigLetters()
    {
        return $this->type['big_letters'] == '1';
    }

    public function rules(): array
    {
        return ['symbols' => [self::RULE_REQUIRED,
                              self::RULE_NUMBERS,
                              [self::RULE_MAX, 'max' => 2],
                              [self::RULE_MAX_NUMBER, 'max_number' => $this->max_symbols],
                              [self::RULE_MIN_NUMBER, 'min_number' => 3]],
                'type' => [self::RULE_CHECKED]
               ];
    }

}