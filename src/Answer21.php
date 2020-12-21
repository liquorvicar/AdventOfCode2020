<?php

namespace AdventOfCode;

class Answer21 extends Base
{

    public function one(array $input)
    {
        $ingredients = [];
        $recipes = [];
        while (!empty($input)) {
            $recipe = trim(array_shift($input));
            $matches = explode('(', $recipe);
            $theseIngredients = explode(' ', $matches[0]);
            $theseIngredients = array_filter(array_map(function ($ingredient) {
                return trim($ingredient);
            }, $theseIngredients));
            $allergenList = trim($matches[1], ')');
            $allergenList = substr($allergenList, 9);
            $allergens = explode(',', $allergenList);
            foreach ($allergens as $allergen) {
                $allergen = trim($allergen);
                if (!isset($ingredients[$allergen])) {
                    $ingredients[$allergen] = [];
                }
                $ingredients[$allergen][] = array_filter($theseIngredients);
            }
            $recipes[] = $theseIngredients;
        }
        $allergens = [];
        $done = false;
        while (!$done) {
            $done = true;
            foreach ($ingredients as $allergen => $possibleIngredients) {
                if (count($possibleIngredients) < 2) {
                    continue;
                }
                $ingredient = array_intersect(...$possibleIngredients);
                if ($ingredient) {
                    $done = false;
                }
                if (count($ingredient) === 1) {
                    $allergens[$allergen] = reset($ingredient);
                }
            }
            $ingredients = array_map(function ($ingredients) use ($allergens) {
                return array_map(function ($ingredients) use ($allergens) {
                    return array_diff($ingredients, array_values($allergens));
                }, $ingredients);
            }, $ingredients);
        }
        foreach ($ingredients as $allergen => $possibleIngredient) {
            $possibleIngredients = array_unique(array_reduce($possibleIngredient, function ($ingredients, $possibles) {
                return array_merge($ingredients, $possibles);
            }, []));
            if (count($possibleIngredients) === 1 && !isset($allergens[$allergen])) {
                $allergens[$allergen] = reset($possibleIngredients);
            }
        }
        $recipes = array_map(function ($recipe) use ($allergens) {
            return array_diff($recipe, array_values($allergens));
        }, $recipes);

        return array_reduce($recipes, function ($sum, $ingredients) {
            return $sum + count($ingredients);
        }, 0);
    }

    public function two(array $input)
    {
        $ingredients = [];
        $recipes = [];
        while (!empty($input)) {
            $recipe = trim(array_shift($input));
            $matches = explode('(', $recipe);
            $theseIngredients = explode(' ', $matches[0]);
            $theseIngredients = array_filter(array_map(function ($ingredient) {
                return trim($ingredient);
            }, $theseIngredients));
            $allergenList = trim($matches[1], ')');
            $allergenList = substr($allergenList, 9);
            $allergens = explode(',', $allergenList);
            foreach ($allergens as $allergen) {
                $allergen = trim($allergen);
                if (!isset($ingredients[$allergen])) {
                    $ingredients[$allergen] = [];
                }
                $ingredients[$allergen][] = array_filter($theseIngredients);
            }
            $recipes[] = $theseIngredients;
        }
        $allergens = [];
        $done = false;
        while (!$done) {
            $done = true;
            foreach ($ingredients as $allergen => $possibleIngredients) {
                if (count($possibleIngredients) < 2) {
                    continue;
                }
                $ingredient = array_intersect(...$possibleIngredients);
                if ($ingredient) {
                    $done = false;
                }
                if (count($ingredient) === 1) {
                    $allergens[$allergen] = reset($ingredient);
                }
            }
            $ingredients = array_map(function ($ingredients) use ($allergens) {
                return array_map(function ($ingredients) use ($allergens) {
                    return array_diff($ingredients, array_values($allergens));
                }, $ingredients);
            }, $ingredients);
        }
        foreach ($ingredients as $allergen => $possibleIngredient) {
            $possibleIngredients = array_unique(array_reduce($possibleIngredient, function ($ingredients, $possibles) {
                return array_merge($ingredients, $possibles);
            }, []));
            if (count($possibleIngredients) === 1 && !isset($allergens[$allergen])) {
                $allergens[$allergen] = reset($possibleIngredients);
            }
        }
        ksort($allergens);

        return implode(',', array_values($allergens));
    }
}

