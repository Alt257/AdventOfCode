<?php

namespace Advent2024\Day1;

use Entity\Solution;

require_once 'AbstractDay1.php';

class Day1Part1 extends AbstractDay1 {

    function __construct() {
        parent::__construct(1);
        $this->addSolution('Mes Données', [
            '2    5',
            '3 6',
            '3 6',
            '3 6',
            '3 6',
            '3 6',
            '3 6',
        ]);
    }

    protected function resolve(Solution $solution,
                               array    $data,
    ): int {
        $distancesList = [];

        $leftList  = $data[self::LEFT_LIST];
        $rightList = $data[self::RIGHT_LIST];

        // sort both lists smaller to bigger
        sort($leftList);
        sort($rightList);

        for($i = 0; $i < sizeof($leftList); $i++) {
            $distance        = abs($leftList[$i] - $rightList[$i]);
            $distancesList[] = $distance;

            $solution->setCalculation($i, "|$leftList[$i]  -  $rightList[$i]|  = $distance");
        }

        return array_sum($distancesList);
    }

}

(new Day1Part1())->run();