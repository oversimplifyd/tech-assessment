<?php

namespace HelloFresh\Recipe\Validator;

/**
 * @author Arotimi Busayo <arotimi.busayo@gmail.com>
 *
 * Class Validator
 * @package HelloFresh\Recipe\Validator
 */
class Validator
{
    private static $messageStack = [];

    /**
     * @param array $input
     * @return array
     */
    public static function createRecipeValidator(array $input)
    {
        self::clearMessageStack();

        self::validate('name', $input, 'required|string');
        self::validate('prep_time', $input, 'required|integer');
        self::validate('difficulty', $input, 'required|integer');
        self::validate('vegetarian', $input, 'required|boolean');

        return self::$messageStack;
    }

    /**
     * @param array $input
     * @return array
     */
    public static function updateRecipeValidator(array $input)
    {
        self::clearMessageStack();

        self::validate('name', $input, 'string');
        self::validate('prep_time', $input, 'integer');
        self::validate('difficulty', $input, 'integer');
        self::validate('vegetarian', $input, 'boolean');

        return self::$messageStack;
    }

    /**
     * @param array $input
     * @return array
     */
    public static function createRatingValidator(array $input)
    {
        self::clearMessageStack();

        self::validate('rating', $input, 'required|integer');

        return self::$messageStack;
    }

    /**
     * @param array $input
     * @return array
     */
    public static function createSearchValidator(array $input)
    {
        self::clearMessageStack();

        self::validate('name', $input, 'required|string');

        return self::$messageStack;
    }

    /**
     * @param string $name
     * @param array $input
     * @param string $rules
     */
    private static function validate(string $name, array $input, string $rules)
    {
        $rules = preg_split('/\|/', $rules);

        foreach ($rules as $rule) {
            switch ($rule) {
                case 'required':
                    self::isRequired($name, $input);
                    break;
                case 'string':
                    self::isString($name, $input);
                    break;
                case 'integer':
                    self::isInteger($name, $input);
                    break;
                case 'boolean':
                    self::isBoolean($name, $input);
            }
        }
    }

    /**
     * @param string $input
     * @param array $parent
     */
    private static function isRequired(string $input, array $parent)
    {
        if (! isset($parent[$input]) || empty($parent[$input])) {
            self::$messageStack[] = $input. ' is required';
        }
    }

    /**
     * @param string $input
     * @param array $parent
     */
    private static function isInteger(string $input, array $parent)
    {
        if (isset($parent[$input]) && ! filter_var($parent[$input], FILTER_VALIDATE_INT)) {
            self::$messageStack[] = $input. ' must be an integer';
        }
    }

    /**
     * @param string $input
     * @param array $parent
     */
    private function isString(string $input, array $parent)
    {
        if (isset($parent[$input]) && !preg_match("/^[A-Za-z\\-\s\d]+$/", $parent[$input])) {
            self::$messageStack[] = $input. ' is not a valid string';
        }
    }

    /**
     * @param string $input
     * @param array $parent
     */
    private function isBoolean(string $input, array $parent)
    {
        if (isset($parent[$input]) && ! filter_var($parent[$input], FILTER_VALIDATE_BOOLEAN)) {
            self::$messageStack[] = $input. ' must be a valid boolean';
        }
    }

    protected static function clearMessageStack()
    {
        self::$messageStack = [];
    }
}
