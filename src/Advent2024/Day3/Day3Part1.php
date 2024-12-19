<?php

namespace Advent2024\Day3;

require_once('AbstractDay3.php');

use Entity\Solution;

class Day3Part1 extends AbstractDay3 {

    function __construct() {
        parent::__construct(1);
    }

    protected function resolve(Solution $solution,
                               array    $data,
    ): int {
        $total = 0;

        foreach($data as $col) {
            $rowTotal = 0;
            foreach($col as $rowNum => $instruction) {
                $rowTotal += $instruction[1];
            }
            $solution->setCalculation($rowNum, $total);
            $total += $rowTotal;
        }

//        var_dump($data);
        return $total;
    }

}

(new Day3Part1())->run();