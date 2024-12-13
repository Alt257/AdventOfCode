<?php

namespace AOC\Advent2024\Day2;

use AOC\Entity\Solution;

require_once 'AbstractDay2.php';

class Day2Part2 extends AbstractDay2 {

    protected const COLOR_SAFETY_ACTIVATED = 'blue';
    protected const COLOR_UNSAFE           = 'red';

    function __construct() {
        parent::__construct(2);
        $this->addSolution('Custom', [
            '5 6 4 7 3 2 8 1',
            '4 5 6 7',
            '40 5 6 7',
            '4 50 6 7',
            '4 5 60 7',
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
            '21 20 19 18 17 22',
        ]);
    }

    protected function resolve(Solution $solution,
                               array    $data,
    ): int {
        $safeReportsCounter = 0;

        foreach($data['Report'] as $reportNumber => $report) {
            $isSafe         = true;
            $redNosedSafety = 1;

            $countASC  = 0;
            $countDESC = 0;

            for($i = 1; $i < sizeof($report); $i++) {
                if($report[$i - 1] < $report[$i]) $countASC++;
                else                              $countDESC++;
            }

            $isAscending = $countASC >= $countDESC;

            $i = 1;
            if(!$this->isSafe($report[0], $report[1], $isAscending)
                && array_key_exists(2, $report)
                && $this->isSafe($report[1], $report[2], $isAscending)
            ) {
                $redNosedSafety--;
                $solution->highlightData(self::COLOR_SAFETY_ACTIVATED,
                                         self::COLUMN_REPORT, $reportNumber, 0,
                );
                $i++;
            }

            for(; $i < sizeof($report); $i++) {
                // SAFE
                if($this->isSafe($report[$i - 1], $report[$i], $isAscending)) {
                    continue;
                }
                // RED NOSED SECURITY
                if($redNosedSafety > 0) {
                    $redNosedSafety--;
//                    $solution->setDataStyle(self::CSS_RED_NOSED_DATA, 'Report', $reportNumber, $i);
                    $solution->highlightData(self::COLOR_SAFETY_ACTIVATED,
                                             self::COLUMN_REPORT, $reportNumber, $i,
                    );

                    // i + 1 doesn't exist
                    if(!array_key_exists($i + 1, $report)) {
                        continue;
                    }
                    // i + 1 exists
                    $i++;
                    if($this->isSafe($report[$i - 2], $report[$i], $isAscending)) {
                        continue;
                    }
                }
                // UNSAFE
//                $solution->setDataStyle(self::CSS_UNSAFE_DATA, 'Report', $reportNumber, $i);
                $solution->highlightData(self::COLOR_UNSAFE,
                                         self::COLUMN_REPORT, $reportNumber, $i,
                );
                $isSafe = false;
            }

            /*======================================================*/

            //@formatter:off
            $security = '['
                      . $this->style($isSafe ? self::SAFE : self::UNSAFE)
                      . ']';
            
            $order = $isAscending ? 'Ascending' : 'Descending';

            $calculation = $this->col($security, '6em')
                         . $this->col($order, '4em')
            ;
            //@formatter:on
            $solution->setCalculation($reportNumber, $calculation);

            $safeReportsCounter += $isSafe ? 1 : 0;
        }

        var_dump($solution->getDataStyles());
        return $safeReportsCounter;
    }

    private function isSafe(int   $level,
                            int   $nextLevel,
                            ?bool $ascending = null,
    ): bool {
        $levelDiff = $nextLevel - $level;

        if($ascending === null) {
            $ascending = true;
            $levelDiff = abs($levelDiff);
        }
        $min = $ascending ? self::MIN_LEVEL_DIFF : -self::MAX_LEVEL_DIFF;
        $max = $ascending ? self::MAX_LEVEL_DIFF : -self::MIN_LEVEL_DIFF;

        return $min <= $levelDiff && $levelDiff <= $max;
    }

}

(new Day2Part2())->run();