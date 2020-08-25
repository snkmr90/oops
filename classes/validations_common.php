<?php

class Validator
{
    /**
     * Is form valid;
     *
     * @var bool
     */
    private $isValid = true;
    /**
     * List of errors, assoc array with error messages one per fieldName
     *
     * @var array
     */
    private $errors = [];

    /**
     * Check if form is valid
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->isValid;
    }

    /**
     * Get error message
     *
     * @param $fieldName
     * @return mixed|string
     */
    public function getError($fieldName)
    {
        return isset($this->errors[$fieldName]) ? $this->errors['fieldName'] : '';
    }

    /**
     * @param array $rules list of rules
     * @param array $payload list of form parameters
     * @return bool Return validation result, same as isValid
     */
    public function validate(array $rules, array $payload)
    {
        foreach ($rules as $rule) {
            if (!$this->validateRequired($rule, $payload)) {
                continue;
            }
            if(isset($rule['type'])):
            switch ($rule['type']) {
                case 'string':
                    $this->validateString($rule, $payload);
                    break;
                case 'email':
                    $this->validateEmail($rule, $payload);
                    break;
                    //extend with other validation rules as needed
            }
        	endif;
        }

        return $this->errors;
    }

    public function validateRequired($rule, $payload)
    {
        if (true === $rule['required'] && $payload[$rule['fieldName']] =='') {
            $this->isValid = false;
            $this->errors[$rule['fieldName']] = "The {$rule['fieldName']} field is required";

            return false;
        }

        return true;
    }

    public function validateString($rule, $payload)
    {
        // Checkup logic, set $this->isValid to false if not valid, add
        // See add $this->errors[$rule['fieldname']] = 'your message';
    }

    public function validateEmail($rule, $payload)
    {
        // Checkup logic, set $this->isValid to false if not valid, add
        // See add $this->errors[$rule['fieldname']] = 'your message';
			if ('email' === $rule['type'] && !filter_var($payload[$rule['type']], FILTER_VALIDATE_EMAIL)) {
            $this->isValid = false;
            $this->errors[$rule['type']] = 'Please enter a valid email address';
            return false;
        }

        return true;
    }

}

// Call validator by giving validator ruleset in the format
// if false do repeat form with error messages shown
// use $validator->getError('firstName'); to get error message for a field.
