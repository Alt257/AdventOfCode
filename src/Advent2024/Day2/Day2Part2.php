<?php

namespace AOC\Advent2024\Day2;

use AOC\Entity\Solution;

require_once 'AbstractDay2.php';
require_once '../AbstractDay2024.php';

class Day2Part2 extends AbstractDay2 {

    protected const CSS_RED_NOSED = [
        'font-weight'      => 'bold',
        'color'            => 'white',
        'background-color' => 'blue',
        'border-radius'    => '5px',
    ];

    function __construct() {
        parent::__construct(1);
//        $this->addSolution('Custom', [
//            '1 2 3 4',
//            '412 245 313',
//            '5 7 9 11 13 15 19',
//        ]);
    }

    protected function resolve(Solution $solution,
                               array    $data,
    ): int {
        $safeReportsCounter = 0;

        foreach($data['Report'] as $reportNumber => $report) {
            $isSafe         = true;
            $redNosedSafety = 1;

            $ascending = $report[0] > $report[1];
            $min       = $ascending ? self::MIN_DIFF_LEVEL : -self::MAX_DIFF_LEVEL;
            $max       = $ascending ? self::MAX_DIFF_LEVEL : -self::MIN_DIFF_LEVEL;


            for($i = 0; $i < sizeof($report) - 1; $i++) {
                $levelDiff = $report[$i] - $report[$i + 1];

                if($this->isSafe($levelDiff, $min, $max)) {
                    continue;
                }
                if($redNosedSafety > 0 && array_key_exists($i - 1, $report)) {
                    $redNosedSafety--;
                    $solution->setDataStyle(self::CSS_RED_NOSED, 'Report', $reportNumber, $i + 1);

                    $levelDiff = $report[$i - 1] - $report[$i + 1];
                    if($this->isSafe($levelDiff, $min, $max)) {
                        continue;
                    }
                }

                $solution->setDataStyle(self::CSS_UNSAFE, 'Report', $reportNumber, $i + 1);
                $isSafe = false;
            }

            $calculation = '['
                . ($isSafe ? $this->style('SAFE', ['color' => 'green'])
                    : $this->style('UNSAFE', ['color' => 'red']))
                . ']';
            $solution->setCalculation($reportNumber, $calculation);

            $safeReportsCounter += $isSafe ? 1 : 0;
        }

        return $safeReportsCounter;
    }

    private function isSafe(int $levelDiff,
                            int $min,
                            int $max,
    ) {
        return $min <= $levelDiff && $levelDiff <= $max;
    }

}

(new Day2Part2())->run();