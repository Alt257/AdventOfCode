<?php

namespace AOC\Advent2024\Day2;

use AOC\Entity\Solution;

require_once 'AbstractDay2.php';
require_once '../AbstractDay2024.php';

class Day2Part1 extends AbstractDay2 {

    function __construct() {
        parent::__construct(1);
        $this->addSolution('Custom', [
            '1 2 3 4',
            '412 245 313',
            '5 7 9 11 13 15 19',
        ]);
    }

    protected function resolve(Solution $solution,
                               array    $data,
    ): int {
        $safeReportsCounter = 0;

        foreach($data['Report'] as $reportNumber => $report) {
            $isSafe = true;

            $ascending = $report[1] > $report[0];
            $min       = $ascending ? self::MIN_LEVEL_DIFF : -self::MAX_LEVEL_DIFF;
            $max       = $ascending ? self::MAX_LEVEL_DIFF : -self::MIN_LEVEL_DIFF;

            $i = 1;
            do {
                $levelDiff = $report[$i] - $report[$i - 1];

                if($levelDiff < $min || $levelDiff > $max) {
                    $solution->setDataStyle(self::CSS_UNSAFE_DATA, 'Report', $reportNumber, $i);
                    $isSafe = false;
                }
                $i++;
            } while($i < sizeof($report));

            $calculation = '['
                . ($isSafe ? $this->style(self::SAFE) : $this->style(self::UNSAFE))
                . ']';
            $solution->setCalculation($reportNumber, $calculation);

            $safeReportsCounter += $isSafe ? 1 : 0;
        }

        return $safeReportsCounter;
    }

}

(new Day2Part1())->run();