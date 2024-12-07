<?php

namespace AOC\Advent2024\Day2;

use AOC\Entity\Solution;

require_once 'AbstractDay2.php';
require_once '..\..\Entity\Solution.php';

class Day2Part2 extends AbstractDay2 {

    function __construct() {
        parent::__construct(2);
    }

//    protected function resolve(Solution $solution, array $data): int {
//        $solution->setInputLabel('Report')
//                 ->setCalculationLabel('Security');
//
//        $safeReportsCounter = 0;
//
//        foreach($data as $report) {
//            $redNosedSafety = 1;
//            $isSafe         = true;
//
//            $input = $this->style($report[0]);
//
//            $ascending = $report[1] > $report[0];
//            $min       = $ascending ? self::MIN_DIFF_LEVEL : -self::MAX_DIFF_LEVEL;
//            $max       = $ascending ? self::MAX_DIFF_LEVEL : -self::MIN_DIFF_LEVEL;
//
//            for($i = 1; $i < sizeof($report); $i++) {
//                $levelDiff = $report[$i] - $report[$i - 1];
//
//                //// SAFE \\\\
//                if($levelDiff >= $min && $levelDiff <= $max) {
//                    $input .= $this->style($report[$i]);
//                    continue;
//                }
//                //// UNSAFE \\\\
//                if($redNosedSafety-- <= 0) {
//                    // no more red nosed safety
//                    $input  .= $this->style($report[$i], ['color' => 'red', 'font-weight' => 'bold']);
//                    $isSafe = false;
//                    continue;
//                }
//                //// red nosed safety remaining \\\\
//                $input .= $this->style($report[$i], ['color' => 'blue', 'font-weight' => 'bold']);
//                if(($i + 1) >= sizeof($report)) {
//                    // no next element
//                    // SAFE thanks to red nosed reactor safety
//                    continue;
//                }
//
//                // "Removing" current element, using the red nosed safety
//                $newLevelDiff = $report[$i + 1] - $report[$i - 1];
//                $i++;
//
//                if($newLevelDiff >= $min && $newLevelDiff <= $max) {
//                    // SAFE thanks to red nosed reactor safety
//                    $input .= $this->style($report[$i]);
//                }
//                else {
//                    $input  .= $this->style($report[$i], ['color' => 'red', 'font-weight' => 'bold']);
//                    $isSafe = false;
//                }
//
//            }
//
//            $calculation = '['
//                . ($isSafe ? $this->style('SAFE', ['color' => 'green'])
//                    : $this->style('UNSAFE', ['color' => 'red']))
//                . ']';
//            $solution->addData($input, $calculation);
//
//            $safeReportsCounter += $isSafe ? 1 : 0;
//        }
//
//        return $safeReportsCounter;
//    }

    public function resolve(Solution $solution,
                            array    $data,
    ): int {

        $solution->setCalculationLabel('Security');

        $safeReportsCounter = 0;

        foreach($data as $report) {
            $cleanedReport      = $this->useSafetyOnReport($report);
            $safeReportsCounter += $this->checkReport($cleanedReport) ? 1 : 0;
        }

        return $safeReportsCounter;
    }

    private function useSafetyOnReport($report): array {
        $redNosedReport = [];
        $redNosedSafety = 1;

        $ascending = $report[1] > $report[0];
        $min       = $ascending ? self::MIN_DIFF_LEVEL : -self::MAX_DIFF_LEVEL;
        $max       = $ascending ? self::MAX_DIFF_LEVEL : -self::MIN_DIFF_LEVEL;

        for($i = 1; $i < sizeof($report); $i++) {

            if(!$this->isSafe($report[$i - 1], $report[$i], $min, $max) && ($redNosedSafety-- <= 0)) {
                continue;
            }
            $redNosedReport[] = $report[$i];
        }
        return $redNosedReport;
    }

    private function checkReport($report): bool {

        $isSafe = true;

        $input = $this->style($report[0]);

        $ascending = $report[1] > $report[0];
        $min       = $ascending ? self::MIN_DIFF_LEVEL : -self::MAX_DIFF_LEVEL;
        $max       = $ascending ? self::MAX_DIFF_LEVEL : -self::MIN_DIFF_LEVEL;

        for($i = 1; $i < sizeof($report); $i++) {
            $levelDiff = $report[$i] - $report[$i - 1];

            //// SAFE \\\\
            if($levelDiff >= $min && $levelDiff <= $max) {
                $input .= $this->style($report[$i]);
                continue;
            }
            //// UNSAFE \\\\
            $input  .= $this->style($report[$i], ['color' => 'red', 'font-weight' => 'bold']);
            $isSafe = false;
        }

        return $isSafe;
    }

    private function isSafe(int $previousLevel,
                            int $level,
                            int $minDiffAllowed,
                            int $maxDiffAllowed,
    ): bool {
        $diff = $previousLevel - $level;

        return $diff >= $minDiffAllowed && $diff <= $maxDiffAllowed;
    }

}

(new Day2Part2())->run();