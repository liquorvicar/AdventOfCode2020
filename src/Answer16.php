<?php

namespace AdventOfCode;

class Answer16 extends Base
{

    public function one(array $input)
    {
        list($rules, $myTicket, $otherTickets) = $this->parseInput($input);
        $errors = [];
        foreach ($otherTickets as $ticket) {
            $errors = array_merge($errors, $this->findInvalidValues($ticket, $rules));
        }

        return array_sum($errors);
    }

    public function two(array $input)
    {
        list($rules, $myTicket, $otherTickets) = $this->parseInput($input);
        $allTickets = $otherTickets;
        $allTickets[] = $myTicket;
        $fieldOrder = $this->findFieldOrder($allTickets, $rules);
        $total = 1;
        $myTicket = array_combine(array_values($fieldOrder), array_values($myTicket));
        foreach ($myTicket as $field => $value) {
            if (strpos($field, 'departure') !== false) {
                $total = $total * $value;
            }
        }

        return $total;
    }

    public function parseInput(array $input)
    {
        $rules = [];
        $myTicket = [];
        $otherTickets = [];
        $rulesDone = false;

        while (!empty($input)) {
            $line = trim(array_shift($input));
            if (!$line) {
                if (!empty($rules)) {
                    $rulesDone = true;
                }
                continue;
            }
            if (!$rulesDone) {
                $matches = explode(':', $line);
                $ruleName = $matches[0];
                $matches = explode(' or ', $matches[1]);
                foreach ($matches as $ruleBounds) {
                    list($lower, $upper) = explode('-', $ruleBounds);
                    for ($allowed = (int)$lower; $allowed <= (int)$upper; $allowed++) {
                        $rules[$ruleName][] = $allowed;
                    }
                }
                continue;
            }
            if ($line === 'your ticket:') {
                $ticket = array_shift($input);
                $myTicket = array_map('intval', explode(',', $ticket));
                continue;
            }
            if ($line === 'nearby tickets:') {
                continue;
            }
            $otherTickets[] = array_map('intval', explode(',', $line));
        }

        return [
            $rules,
            $myTicket,
            $otherTickets,
        ];
    }

    public function findFieldOrder(array $tickets, array $rules)
    {
        $validTickets = array_filter($tickets, function ($ticket) use ($rules) {
            return count($this->findInvalidValues($ticket, $rules)) === 0;
        });
        $fieldOrder = [];
        for ($column = 0; $column < count(reset($validTickets)); $column++) {
            $values = array_column($validTickets, $column);
            $possibles = [];
            foreach ($rules as $name => $rule) {
                $validValues = array_filter($values, function ($value) use ($rule) {
                    return array_search($value, $rule, true) !== false;
                });
                if (count($validValues) === count($values)) {
                    $possibles[] = $name;
                }
            }
            $fieldOrder[] = $possibles;
        }
        $singleField = false;
        while (!$singleField) {
            $singleField = true;
            $newFieldOrder = [];
            foreach ($fieldOrder as $possibles) {
                if (is_array($possibles)) {
                    if (count($possibles) === 1) {
                        $newFieldOrder[] = reset($possibles);
                    } else {
                        $newFieldOrder[] = $possibles;
                        $singleField = false;
                    }
                } else {
                    $newFieldOrder[] = $possibles;
                }
            }
            $singleFields = array_filter($newFieldOrder, function ($field) {
                return !is_array($field);
            });
            $fieldOrder = array_map(function ($field) use ($singleFields) {
                if (!is_array($field)) {
                    return $field;
                }
                return array_diff($field, $singleFields);
            }, $newFieldOrder);
        }

        return $fieldOrder;
    }

    protected function findInvalidValues($ticket, $rules): array
    {
        return array_filter($ticket, function ($number) use ($rules) {
            return count(array_filter($rules, function ($rule) use ($number) {
                    return array_search($number, $rule, true) === false;
                })) === count($rules);
        });
    }
}

