<?php

namespace AdventOfCode;

class Answer22 extends Base
{

    public function one(array $input)
    {
        $hands = [0 => [], 1 => []];
        $hand = 0;
        while (!empty($input)) {
            $card = trim(array_shift($input));
            if ($card === 'Player 1:' || strlen($card) === 0) {
                continue;
            } elseif ($card === 'Player 2:') {
                $hand++;
            } else {
                $hands[$hand][] = (int)$card;
            }
        }

        return $this->playGame($hands);
    }

    public function two(array $input)
    {
        $hands = [0 => [], 1 => []];
        $hand = 0;
        while (!empty($input)) {
            $card = trim(array_shift($input));
            if ($card === 'Player 1:' || strlen($card) === 0) {
                continue;
            } elseif ($card === 'Player 2:') {
                $hand++;
            } else {
                $hands[$hand][] = (int)$card;
            }
        }

        return $this->playGame($hands, true);
    }

    public function playRound(array $hands, $recurse): array
    {
        $player1 = array_shift($hands[0]);
        $player2 = array_shift($hands[1]);
        $winningCards = [$player1, $player2];
        if ($recurse && count($hands[0]) >= $player1 && count($hands[1]) >= $player2) {
            $newHands = $hands;
            $newHands[0] = array_slice($hands[0], 0, $player1);
            $newHands[1] = array_slice($hands[1], 0, $player2);
            list($winner, $newHands) = $this->playSubGame($newHands, true);
        } else {
            if ($player1 > $player2) {
                $winner = 0;
            } else {
                $winner = 1;
            }
        }
        if ($winner === 1) {
            $winningCards = array_reverse($winningCards);
        }
        $hands[$winner] = array_merge($hands[$winner], $winningCards);

        return $hands;
    }

    public function playGame(array $hands, $recurse = false): int
    {
        list($winner, $hands) = $this->playSubGame($hands, $recurse);
        $winningHand = array_reverse($hands[$winner]);
        $score = 0;
        foreach (array_values($winningHand) as $index => $card) {
            $score += $card * ($index + 1);
        }

        return $score;
    }

    public function playSubGame(array $hands, $recurse): array
    {
        $game = [];
        while (!empty($hands[0]) && !empty($hands[1])) {
            $round = implode(',', $hands[0]) . ':' . implode(',', $hands[1]);
            if ($recurse && array_search($round, $game) !== false) {
                break;
            }
            $game[] = $round;
            $hands = $this->playRound($hands, $recurse);
        }
        $winner = empty($hands[0]) ? 1 : 0;

        return [$winner, $hands];
    }
}

