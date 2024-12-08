<?php

namespace AOC\Advent2024\Day1;

use AOC\Entity\Solution;

require_once 'AbstractDay1.php';

class Day1Part2 extends AbstractDay1 {

    function __construct() {
        parent::__construct(2);
    }

    protected function resolve(Solution $solution,
                               array    $data,
    ): int {
        $solution->setCalculationLabel("Similarity");

        $similarityList = [];
        $leftList       = $data[self::LEFT_LIST];
        $rightList      = $data[self::RIGHT_LIST];

        $rightValuesOccurences = array_count_values($rightList);

        foreach($leftList as $i => $leftValue) {
            $counter          = $rightValuesOccurences[$leftValue] ?? 0;
            $similarity       = $leftValue * $counter;
            $similarityList[] = $similarity;

            $solution->setCalculation($i, "$similarity");
        }

        return array_sum($similarityList);
    }

}

(new Day1Part2())->run();