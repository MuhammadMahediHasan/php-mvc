<?php

namespace Core;

use Exception;

class Validator
{
    protected array $errors = [];
    protected array $rules = [
        'required' => 'validateRequired',
        'number' => 'validateNumber',
        'max' => 'validateMaxLength',
        'text' => 'validateText',
        'email' => 'validateEmail',
        'unicode' => 'validateUnicode',
        'max_words' => 'validateMaxWords'
    ];

    /**
     * @throws Exception
     */
    public function validate(array $fields): array
    {
        foreach ($fields as $column => $rules) {
            foreach ($rules as $rule) {
                [$ruleName, $ruleValue] = explode(':', $rule . ':');
                if (!array_key_exists($ruleName, $this->rules)) {
                    throw new Exception("Rule '{$ruleName}' does not exist.");
                }

                $method = $this->rules[$ruleName];
                $isValid = $this->$method($_POST[$column] ?? '', $ruleValue);

                if (!$isValid) {
                    $this->errors[$column] = $this->getErrorMessage($column, $ruleName, $ruleValue);
                }
            }
        }
        return $this->errors;
    }

    protected function validateRequired($value): bool
    {
        return !empty(trim($value));
    }

    protected function validateNumber($value): bool
    {
        return is_numeric($value);
    }

    protected function validateMaxLength($value, $max): bool
    {
        return strlen($value) <= (int) $max;
    }

    protected function validateText($value): bool
    {
        return is_string($value);
    }

    protected function validateEmail($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    protected function validateUnicode($value): bool
    {
        return mb_check_encoding($value, 'UTF-8');
    }

    protected function validateMaxWords($value, $max): bool
    {
        return str_word_count($value) <= (int) $max;
    }

    protected function getErrorMessage($column, $rule, $value = null): string
    {
        $messages = [
            'required' => ucfirst($column) . ' is required.',
            'number' => ucfirst($column) . ' must be a number.',
            'max' => ucfirst($column) . " must not exceed $value characters.",
            'text' => ucfirst($column) . ' must contain only letters, numbers, and spaces.',
            'email' => ucfirst($column) . ' must be a valid email address.',
            'unicode' => ucfirst($column) . ' must contain valid Unicode characters.',
            'max_words' => ucfirst($column) . " must not exceed $value words."
        ];

        return $messages[$rule] ?? 'Invalid input.';
    }
}
