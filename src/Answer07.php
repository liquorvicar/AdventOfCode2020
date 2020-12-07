<?php

namespace AdventOfCode;

use AdventOfCode\App\BagRule;

class Answer07 extends Base
{

    public function one(array $input)
    {
        $rawRules = $this->trim($input);
        $rules = $this->parseRules($rawRules);
        $this->logger->debug('Parsed rules', ['count' => count($rules)]);

        return $this->countBagsContaining('shiny gold', $rules);
    }

    public function two(array $input)
    {
        $rawRules = $this->trim($input);
        $rules = $this->parseRules($rawRules);
        $this->logger->debug('Parsed rules', ['count' => count($rules)]);

        return $this->countBagsInside('shiny gold', $rules);
    }

    public function parseRules(array $input): array
    {
        $rules = [];
        foreach ($input as $line) {
            $ruleParts = explode('contain', $line);
            $colour = trim(str_replace('bags', '', $ruleParts[0]));
            $contents = explode(',', trim($ruleParts[1]));
            $colourRules = array_map(function ($colourRuleRaw) {
                if ($colourRuleRaw === 'no other bags.') {
                    return null;
                }
                $matches = [];
                preg_match('/^([0-9]+) ([a-z]+ [a-z]+) bag/', trim($colourRuleRaw), $matches);
                return new BagRule((int)$matches[1], $matches[2]);
            }, $contents);
            $rules[$colour] = array_filter($colourRules);
        }

        return $rules;
    }

    public function countBagsContaining(string $searchColour, array $rules)
    {
        $count = 0;
        foreach ($rules as $colour => $colourRules) {
            if ($colour === $searchColour) {
                continue;
            }
            if ($this->bagContains($searchColour, $colourRules, $rules)) {
                $count++;
            }
        }

        return $count;
    }

    private function bagContains(string $searchColour, $colourRules, array $rules)
    {
        if (empty($colourRules)) {
            return false;
        }
        $matchingRule = array_filter($colourRules, function (BagRule $rule) use ($searchColour) {
            return $rule->getColour() === $searchColour;
        });
        if (!empty($matchingRule)) {
            return true;
        }
        $rulesToCheck = [];
        foreach ($colourRules as $rule) {
            $rulesToCheck = array_merge($rulesToCheck, $rules[$rule->getColour()]);
        }

        return $this->bagContains($searchColour, $rulesToCheck, $rules);
    }

    public function countBagsInside(string $searchColour, array $rules, $qty = 1): int
    {
        $count = 0;
        $colourRules = $rules[$searchColour];
        foreach ($colourRules as $colourRule) {
            $count+= ($colourRule->getCount() * $qty);
            $count+= $this->countBagsInside($colourRule->getColour(), $rules, $qty *$colourRule->getCount());
        }
        $this->logger->debug('Counting bags', ['colour' => $searchColour, 'count' => $count]);

        return $count;
    }
}

