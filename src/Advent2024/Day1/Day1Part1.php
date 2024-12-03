<?php

namespace AOC\Advent2024\Day1;

require_once 'AbstractDay1.php';

class Day1Part1 extends AbstractDay1 {


    protected function resolve(array $data): int {
        $distancesList = [];
        $leftList      = $data[self::LEFT_LIST];
        $rightList     = $data[self::RIGHT_LIST];

        // sort both lists smaller to bigger
        sort($leftList);
        sort($rightList);

        for($i = 0; $i < sizeof($leftList); $i++) {
            $distance        = abs($leftList[$i] - $rightList[$i]);
            $distancesList[] = $distance;
//            echo "<div>" . $leftList[$i] . " - " . $rightList[$i] . " = $distance</div>";
        }

        return array_sum($distancesList);
    }

}

(new Day1Part1())->run(); 