<?php

namespace AOC\Advent2024\Day2;

use AOC\Entity\Solution;

require_once 'AbstractDay2.php';
require_once '../AbstractDay2024.php';

class Day2Part2 extends AbstractDay2 {

    protected const CSS_RED_NOSED_DATA = [
        'font-weight'      => 'bold',
        'color'            => 'white',
        'background-color' => 'blue',
        'border-radius'    => '5px',
    ];

    function __construct() {
        parent::__construct(2);
        $this->addSolution('Custom', [
            '1 2 3 4 3 5 6 7',
            '1 2 3 4 3 4 6 7',
            '19 7 6 4 3 1',
            '19 7',
            '9 7 8 6 5 4 3 2 1',
            '5 7 9 11 13 15 19',
            '5 7 9 11 13 15 15',
            '5 7 9 11 13 13 19 21',
            '5 7 9 11 13 13 9 19 21',
            '5 7 9 11 13 9 19 21',
            '20 21 20 19 18 17',
        ]);
    }

    protected function resolve(Solution $solution,
                               array    $data,
    ): int {
        $safeReportsCounter = 0;

        foreach($data['Report'] as $reportNumber => $report) {
            $isSafe         = true;
            $redNosedSafety = 1;

            $ascending = $report[0] < $report[1];
            $min       = $ascending ? self::MIN_DIFF_LEVEL : -self::MAX_DIFF_LEVEL;
            $max       = $ascending ? self::MAX_DIFF_LEVEL : -self::MIN_DIFF_LEVEL;


            for($i = 1; $i < sizeof($report); $i++) {
                $levelDiff = $report[$i] - $report[$i - 1];
                // SAFE
                if($this->isSafe($levelDiff, $min, $max)) {
                    continue;
                }
                // RED NOSED SECURITY
                if($redNosedSafety > 0) {
                    $redNosedSafety--;

                    // i + 1 doesn't exist
                    if(!array_key_exists($i + 1, $report)) {
                        $solution->setDataStyle(self::CSS_RED_NOSED_DATA, 'Report', $reportNumber, $i);
                        continue;
                    }
                    // i + 1 exists
                    $i++;
                    $levelDiff = $report[$i] - $report[$i - 2];
                    if($this->isSafe($levelDiff, $min, $max)) {
                        $solution->setDataStyle(self::CSS_RED_NOSED_DATA, 'Report', $reportNumber, $i - 1);
                        continue;
                    }

                    if($i - 2 == 0) {
                        $solution->setDataStyle(self::CSS_RED_NOSED_DATA, 'Report', $reportNumber, 0);
                        $levelDiff = $report[$i] - $report[$i - 1];
                        if($this->isSafe($levelDiff, $min, $max)) {
                            continue;
                        }
                    }
                }
                // UNSAFE
                $solution->setDataStyle(self::CSS_UNSAFE_DATA, 'Report', $reportNumber, $i);
                $isSafe = false;
            }

            //@formatter:off
            $calculation = '['
                         . ($isSafe ? $this->style(self::PRINT_SAFE)
                                    : $this->style(self::PRINT_UNSAFE))
                         . ']';
            //@formatter:on
            $solution->setCalculation($reportNumber, $calculation);

            $safeReportsCounter += $isSafe ? 1 : 0;
        }

        var_dump($solution->getDataStyles());
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