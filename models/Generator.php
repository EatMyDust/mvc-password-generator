<?php

namespace app\models;

use app\core\Model;

class Generator extends Model
{
    public string $symbols;
    public $numbers;
    public $big_letters;
    public $small_letters;

    public function generateCode(): string
    {
        $result = [];
        $symbolsArray = [];
        $symbolsCount = $this->symbols;

        $arrayNumbers = $this->arrayNumbers();
        $arrayBigLetters = $this->arrayBigLetters();
        $arraySmallLetters = $this->arraySmallLetters();

        if($this->isNumbers() && $this->isBigLetters() && $this->isSmallLetters())
        {
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

        foreach (array_rand($symbolsArray, $symbolsCount) as $symbolKey){
            $result[] = $symbolsArray[$symbolKey];
        }

        return implode("", $result);
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
        return $this->numbers == '1';
    }

    protected function isSmallLetters()
    {
        return $this->small_letters == '1';
    }

    protected function isBigLetters()
    {
        return $this->big_letters == '1';
    }

    public function rules(): array
    {
        return ['symbols' => [self::RULE_REQUIRED, [self::RULE_MAX, 'max' => 1], self::RULE_NUMBERS]];
    }

}