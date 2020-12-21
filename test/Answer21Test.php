<?php

namespace AdventOfCode\Test;

use AdventOfCode\Answer21;

class Answer21Test extends BaseTest
{
    /**
     * @var Answer21
     */
    protected $answer;

    public function setUp(): void
    {
        parent::setUp();
        $this->answer = new Answer21($this->logger);
    }

    public function testOne()
    {
        $input = [
            'mxmxvkd kfcds sqjhc nhms (contains dairy, fish)',
            'trh fvjkl sbzzf mxmxvkd (contains dairy)',
            'sqjhc fvjkl (contains soy)',
            'sqjhc mxmxvkd sbzzf (contains fish)',
        ];
        $this->assertEquals(5, $this->answer->one($input));
    }
}