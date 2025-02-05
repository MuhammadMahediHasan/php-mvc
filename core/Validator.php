<?php

namespace Core;

class Validator
{
    protected static array $errors = [];

    /**
     * @param $column
     * @param $rules
     * @return string|null
     */
    public static function make($column, $rules): ?string
    {
        foreach ($rules as $rule) {
            $result = self::applyRule($column, $rule);
            if ($result) {
                return $result;
            }
        }
        return null;
    }

    /**
     * @param $column
     * @param $rule
     * @return string|null
     */
    private static function applyRule($column, $rule): ?string
    {
        $ruleParts = explode(':', $rule);
        $ruleName = $ruleParts[0];
        $ruleValue = $ruleParts[1] ?? null;

        return match ($ruleName) {
            'required' => self::validateRequired($column),
            'number' => self::validateNumber($column),
            'max' => self::validateMaxLength($column, $ruleValue),
            'text' => self::validateText($column),
            'email' => self::validateEmail($column),
            'unicode' => self::validateUnicode($column),
            'max_words' => self::validateMaxWords($column, $ruleValue),
            default => null,
        };
    }

    /**
     * @param $column
     * @return string|null
     */
    private static function validateRequired($column): ?string
    {
        $value = $_POST[$column] ?? null;
        if (empty($value)) {
            return ucfirst($column) . ' is required.';
        }
        return null;
    }

    /**
     * @param $column
     * @return string|null
     */
    private static function validateNumber($column): ?string
    {
        $value = $_POST[$column] ?? null;
        if (!is_numeric($value)) {
            return ucfirst($column) . ' must be a valid number.';
        }
        return null;
    }

    /**
     * @param $column
     * @param $maxLength
     * @return string|null
     */
    private static function validateMaxLength($column, $maxLength): ?string
    {
        $value = $_POST[$column] ?? null;
        if (strlen($value) > $maxLength) {
            return ucfirst($column) . ' must not exceed ' . $maxLength . ' characters.';
        }
        return null;
    }

    /**
     * @param $column
     * @return string|null
     */
    private static function validateText($column): ?string
    {
        $value = $_POST[$column] ?? null;
        if (!preg_match("/^[a-zA-Z0-9 ]*$/", $value)) {
            return ucfirst($column) . ' must contain only letters, numbers, and spaces.';
        }
        return null;
    }

    /**
     * @param $column
     * @return string|null
     */
    private static function validateEmail($column): ?string
    {
        $value = $_POST[$column] ?? null;
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return ucfirst($column) . ' must be a valid email address.';
        }
        return null;
    }

    /**
     * @param $column
     * @return string|null
     */
    private static function validateUnicode($column): ?string
    {
        $value = $_POST[$column] ?? null;
        if (preg_match('/[^\x20-\x7E]/', $value)) { // Matches non-ASCII characters
            return ucfirst($column) . ' must support Unicode characters.';
        }
        return null;
    }

    /**
     * @param $column
     * @param $maxWords
     * @return string|null
     */
    private static function validateMaxWords($column, $maxWords): ?string
    {
        $value = $_POST[$column] ?? null;
        $wordCount = str_word_count($value);
        if ($wordCount > $maxWords) {
            return ucfirst($column) . ' must not exceed ' . $maxWords . ' words.';
        }
        return null;
    }
}
