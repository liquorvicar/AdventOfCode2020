<?php

namespace AdventOfCode;

class Answer19 extends Base
{

    public function one(array $input)
    {
        $rules = [];
        while (true) {
            $line = array_shift($input);
            if (!trim($line)) {
                break;
            }
            $rules[] = trim($line);
        }
        $messages = $input;
        $rules = $this->parseRules($rules);
        $this->logger->debug('Parsed rules', $rules);
        $ruleToCheck = '~^' . $rules[0] . '$~';
        $matchingMessages = array_filter($messages, function ($message) use ($ruleToCheck) {
            return preg_match($ruleToCheck, $message);
        });
        return count($matchingMessages);
    }

    public function two(array $input)
    {
        $rules = [];
        while (true) {
            $line = array_shift($input);
            if (!trim($line)) {
                break;
            }
            $rules[] = trim($line);
        }
        $messages = $this->trim($input);
        $rules = array_map(function ($rule) {
            if (substr($rule, 0, 2) === '8:') {
                return '8: 42 | 42 8';
            } elseif (substr($rule, 0, 3) === '11:') {
                return '11: 42 31 | 42 11 31';
            }
            return $rule;
        }, $rules);
        $rules = $this->parseRules($rules);
        $this->logger->debug('Parsed rules', $rules);
        $ruleToCheck = '~^' . $rules[0] . '$~';
        $rule42 = '~^' . $rules[42] . '$~';
        $rule31 = '~^' . $rules[31] . '$~';
        $matchingMessages = array_filter($messages, function ($message) use ($ruleToCheck, $rule42, $rule31, $actualMatches) {
            if (preg_match_all($ruleToCheck, $message) < 1) {
                return false;
            }
            $matches = [42 => 0, 31 => 0];
            $rule = $rule42;
            while (!empty($message)) {
                $part = substr($message, 0, 8);
                if (preg_match($rule, $part)) {
                    if ($rule === $rule42) {
                        $matches[42]++;
                    } else {
                        $matches[31]++;
                    }
                } else {
                    $rule = $rule31;
                    if (preg_match($rule, $part)) {
                        $matches[31]++;
                    } else {
                        $matches[31] = 0;
                        break;
                    }
                }
                $message = substr($message, 8);
            }
            return $matches[42] > $matches[31];
        });
        return count($matchingMessages);
    }

    public function parseRules(array $input)
    {
        $rules = [];
        while (!empty($input)) {
            $rule = array_shift($input);
            $matches = explode(':', $rule);
            $ruleNumber = (int)$matches[0];
            if (preg_match('/[a-z]/', $matches[1])) {
                $rules[$ruleNumber] = trim(trim($matches[1]), '"');
            } else {
                $ruleParts = explode(' ', $matches[1]);
                $ruleParts = array_filter($ruleParts, function ($part) {
                    return $part && $part !== '|';
                });
                $ruleParts = array_unique($ruleParts);
                $partsExist = array_filter($ruleParts, function ($part) use ($rules, $ruleNumber) {
                    return isset($rules[(int)$part]) || (int)$part === $ruleNumber;
                });
                if (count($ruleParts) !== count($partsExist)) {
                    $input[] = $rule;
                    continue;
                }
                $parsedRule = '';
                $isRecursive = preg_match('/\b' . $ruleNumber . '\b/', $matches[1]);
                foreach (explode(' ', $matches[1]) as $part) {
                    $part = trim($part);
                    if (!$part) {
                        continue;
                    }
                    $subRuleNumber = (int)$part;
                    if (isset($rules[$subRuleNumber])) {
                        $subRule = $rules[$subRuleNumber];
                        if (strlen($subRule) > 1 || $isRecursive) {
                            $parsedRule.= '(';
                            if ($subRuleNumber !== 42 && $subRuleNumber !== 31) {
                                $parsedRule.= '?:';
                            } else {
                                $parsedRule.= '?<r' . $ruleNumber . 'sr' . $subRuleNumber . '>';
                            }
                            $parsedRule.= $subRule . ')';
                            if ($isRecursive) {
                                $parsedRule.= '+';
                            }
                        } else {
                            $parsedRule.= $subRule;
                        }
                    } elseif ($part === '|') {
                        if ($isRecursive) {
                            break;
                        }
                        $parsedRule.= '|';
                    }
                }
                $parsedRule.= '';
                $rules[$ruleNumber] = $parsedRule;
            }
        }

        return $rules;
    }
}

