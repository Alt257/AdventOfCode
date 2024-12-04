<?php

namespace AOC\Advent2024\Day1;

use AOC\Entity\Solution;

require_once 'AbstractDay1.php';

class Day1Part2 extends AbstractDay1 {


    protected function resolve(Solution $solution, array $data): int {
        $similarityList = [];
        $leftList       = $data[self::LEFT_LIST];
        $rightList      = $data[self::RIGHT_LIST];

        $rightValuesOccurences = array_count_values($rightList);

        foreach($leftList as $leftValue) {
            $counter          = $rightValuesOccurences[$leftValue] ?? 0;
            $similarity       = $leftValue * $counter;
            $similarityList[] = $similarity;
        }

        return array_sum($similarityList);
    }

}

(new Day1Part2(2))->run();