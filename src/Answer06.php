<?php

namespace AdventOfCode;

class Answer06 extends Base
{

    public function one(array $input)
    {
        $input = array_map(function ($line) {
            return trim($line);
        }, $input);

        return $this->countGroupsAnyYeses($input);
    }

    public function two(array $input)
    {
        $input = array_map(function ($line) {
            return trim($line);
        }, $input);

        return $this->countGroupsAllYeses($input);
    }

    public function countAnyYesQuestions($group): int
    {
        $questions = array_unique(array_reduce($group, function ($questions, $person) {
            return array_merge($questions, str_split($person));
        }, []));

        return count($questions);
    }

    public function countGroupsAnyYeses(array $input): int
    {
        $countMethod = 'countAnyYesQuestions';

        return $this->countGroups($input, $countMethod);
    }

    public function countAllYesQuestions($group)
    {
        $answers = [];
        foreach ($group as $person) {
            $personYeses = str_split($person);
            foreach ($personYeses as $yes) {
                if (!isset($answers[$yes])) {
                    $answers[$yes] = 0;
                }
                $answers[$yes]++;
            }
        }
        $totalPeople = count($group);
        return array_reduce($answers, function ($count, $answerCount) use ($totalPeople) {
            if ($answerCount === $totalPeople) {
                $count++;
            }

            return $count;
        }, 0);
    }

    public function countGroupsAllYeses(array $input): int
    {
        $countMethod = 'countAllYesQuestions';

        return $this->countGroups($input, $countMethod);
    }

    protected function countGroups(array $input, string $countMethod): int
    {
        $group = [];
        $count = 0;
        foreach ($input as $line) {
            if (!$line) {
                if (!empty($group)) {
                    $count += $this->$countMethod($group);
                }
                $group = [];
            } else {
                $group[] = $line;
            }
        }
        $count += $this->$countMethod($group);

        return $count;
    }
}

