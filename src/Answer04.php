<?php

namespace AdventOfCode;

class Answer04 extends Base
{

    public function one(array $input)
    {
        $passports = $this->parse($input);
        $this->logger->debug('Found passports', ['num' => count($passports)]);
        $numValid = array_reduce($passports, function ($numValid, $passport) {
            $numValid+= (int)$this->validatePassportFields($passport);

            return $numValid;
        }, 0);

        return $numValid;
    }

    public function two(array $input)
    {
        $passports = $this->parse($input);
        $this->logger->debug('Found passports', ['num' => count($passports)]);
        $numValid = array_reduce($passports, function ($numValid, $passport) {
            $numValid+= (int)$this->validatePassport($passport);

            return $numValid;
        }, 0);

        return $numValid;
    }

    public function parse(array $input): array
    {
        $passports = [];
        $thisPassport = [];
        foreach ($input as $line) {
            $line = trim($line);
            if ($line) {
                $thisPassport[] = $line;
            } else {
                $passports[] = implode(' ', $thisPassport);
                $thisPassport = [];
            }
        }
        $passports[] = implode(' ', $thisPassport);

        return array_filter($passports);
    }

    public function validatePassportFields($passport): bool
    {
        if (is_array($passport)) {
            $fields = $passport;
        } else {
            $fields = $this->parsePassportFields($passport);
        }

        $requiredFields = [
            'byr',
            'iyr',
            'eyr',
            'hgt',
            'hcl',
            'ecl',
            'pid',
        ];

        $missingFields = array_diff($requiredFields, array_keys($fields));

        return empty($missingFields);
    }

    public function validateFieldValue(string $field, string $value)
    {
        switch ($field) {
            case 'byr':
                $value = (int)$value;
                return $this->validateNumberRange($value, 1920, 2002);
            case 'iyr':
                $value = (int)$value;
                return $this->validateNumberRange($value, 2010, 2020);
            case 'eyr':
                $value = (int)$value;
                return $this->validateNumberRange($value, 2020, 2030);
            case 'hgt':
                $unit = substr($value, -2);
                $value = (int)substr($value, 0, strlen($value) - 2);
                if ($unit === 'cm') {
                    return $this->validateNumberRange($value, 150, 193);
                } else {
                    return $this->validateNumberRange($value, 59, 76);
                }
            case 'hcl':
                return (bool)preg_match('/^#[a-f0-9]{6}$/', $value);
            case 'ecl':
                return in_array($value, ['amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth']);
            case 'pid':
                return (bool)preg_match('/^[0-9]{9}$/', $value);
        }

        return true;
    }

    /**
     * @param int $value
     * @return bool
     */
    protected function validateNumberRange(int $value, $min, $max): bool
    {
        return $min <= $value && $value <= $max;
    }

    public function validatePassport($passport): bool
    {
        $passport = $this->parsePassportFields($passport);
        if (!$this->validatePassportFields($passport)) {
            return false;
        }
        foreach ($passport as $field => $value) {
            $isValid = $this->validateFieldValue($field, $value);
            if (!$isValid) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $passport
     * @return array
     */
    protected function parsePassportFields(string $passport): array
    {
        $fields = [];
        $rawFields = array_filter(explode(' ', $passport));
        foreach ($rawFields as $rawField) {
            $fieldParts = explode(':', $rawField);
            $fields[trim($fieldParts[0])] = trim($fieldParts[1]);
        }
        return $fields;
    }
}

