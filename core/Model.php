<?php

namespace app\core;

use app\core\db\DbManager;

abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';

    public array $errors = [];

    public const TABLE_NAME = "";
    public const PRIMARY_KEY = "";
    public const ATTRIBUTES = [];
    public const RULES = [];
    public const LABELS = [];

    public function getLabel($attribute): string
    {
        return $this->labels()[$attribute] ?? $attribute;
    }

    public static function tableName(): string
    {
        return static::TABLE_NAME;
    }

    public static function primaryKey(): string
    {
        return static::PRIMARY_KEY;
    }

    public static function attributes(): array
    {
        return static::ATTRIBUTES;
    }

    public static function rules(): array
    {
        return static::RULES;
    }

    public static function labels(): array
    {
        return static::LABELS;
    }


    public function loadData($data): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function validate(): bool
    {
        foreach ($this->rules() as $attribute => $rules){
            $value = $this->{$attribute};
            foreach ($rules as $rule){
                $ruleName = $rule;
                if (!is_string($ruleName)){
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)){
                    $this->addErrorForRule($attribute, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']){
                    $this->addErrorForRule($attribute, self::RULE_MIN, $rule);
                }
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']){
                    $this->addErrorForRule($attribute, self::RULE_MAX, $rule);
                }
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}){
                    $rule['match'] = $this->getLabel($rule['match']);
                    $this->addErrorForRule($attribute, self::RULE_MATCH, $rule);
                }
                if ($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttr = $attribute = $rule['attribute'] ?? $attribute;
                    $foundRecord = DbManager::findOne($className, [$uniqueAttr => $value]);
                    if ($foundRecord) {
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE, ['field' => $this->getLabel($attribute)]);
                    }
                }
            }
        }
        return empty($this->errors);
    }

    public function addError(string $attribute, string $message): void
    {
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be valid email address',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MAX => 'Max length of this field must be {max}',
            self::RULE_MATCH => 'This field must be the same as {match}',
            self::RULE_UNIQUE => 'Record with this {field} already exists',
        ];
    }

    public function hasError($attribute): bool
    {
        return ISSET($this->errors[$attribute]);
    }

    public function getFirstError($attribute): string
    {
        return $this->errors[$attribute][0] ?? '';
    }

    private function addErrorForRule(string $attribute, string $rule, $params = []): void
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value){
            $message = str_replace("{{$key}}",$value, $message);
        }
        $this->errors[$attribute][] = $message;
    }
}