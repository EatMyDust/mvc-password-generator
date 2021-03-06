<?php


namespace app\core;


abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_CORRECT = 'correct';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_NUMBERS = 'numbers';
    public const RULE_MAX_NUMBER = 'max_number';
    public const RULE_MIN_NUMBER = 'min_number';
    public const RULE_CHECKED = 'checked';

    public function loadData($data): void
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    abstract public function rules(): array;

    public $errors = [];

    public function validate()
    {
        foreach ($this->rules() as $attr => $rules){
            $value = $this->{$attr};
            foreach ($rules as $rule)
            {
                $name = $rule;
                if(!is_string($name)){
                    $name = $rule[0];
                }
                if($name === self::RULE_REQUIRED && !$value){
                    $this->addError($attr, self::RULE_REQUIRED);
                }
                if($name === self::RULE_NUMBERS && !preg_match('#^[0-9]*$#', $value)){
                    $this->addError($attr, self::RULE_NUMBERS);
                }
                if($name === self::RULE_MIN && strlen($value) < $rule['min']){
                    $this->addError($attr, self::RULE_MIN, $rule);
                }
                if($name === self::RULE_MAX && strlen($value) > $rule['max']){
                    $this->addError($attr, self::RULE_MAX, $rule);
                }
                if($name === self::RULE_MAX_NUMBER && $value > $rule['max_number']){
                    $this->addError($attr, self::RULE_MAX_NUMBER, $rule);
                }
                if($name === self::RULE_MIN_NUMBER && $value < $rule['min_number']){
                    $this->addError($attr, self::RULE_MIN_NUMBER, $rule);
                }
                if($name === self::RULE_CHECKED && is_null($value)){
                    $this->addError($attr, self::RULE_CHECKED);
                }
            }

        }
        return empty($this->errors);
    }

    public function addError(string $attr, string $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attr][] = $message;
    }

    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'Field is required',
            self::RULE_CORRECT => 'Wrong login or password',
            self::RULE_MIN => 'Min length of this field is {min}',
            self::RULE_MAX => 'Max length of this field is {max}',
            self::RULE_NUMBERS => 'This field require only numbers',
            self::RULE_MIN_NUMBER => 'Min number is {min_number}',
            self::RULE_MAX_NUMBER => 'Max number is {max_number}',
            self::RULE_CHECKED => 'This field need to be checked',
        ];
    }

    public function hasError($attr = ''): bool
    {
        $result = false;

        if($attr && isset($this->errors[$attr]) && count($this->errors[$attr])>0){
            $result = true;
        }else if(!$attr && count($this->errors)>0){
            $result = true;
        }
        return $result;
    }

    public function getFirstError($attr = ''): string
    {
        if($attr){
            $result = $this->errors[$attr][0] ?? '';
        }else{
            $result = current($this->errors)[0] ?? '';
        }
        return $result;
    }

    public function isRequired($attr): string
    {
        $result = '';
        if(isset($this->rules()[$attr])) {
            $result = array_search(self::RULE_REQUIRED, $this->rules()[$attr]) === false ? '' : '*';
        }
        return $result;
    }
}