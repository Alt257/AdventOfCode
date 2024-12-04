<?php

namespace AOC\Advent2024\Day2;

use AOC\Entity\Solution;

require_once 'AbstractDay2.php';
require_once '../AbstractDay2024.php';

class Day2Part1 extends AbstractDay2 {

    private const  MIN_DIFF_LEVEL = 1;
    private const  MAX_DIFF_LEVEL = 3;

    private const  SECURITY_OK     = '<span style="color: green">OK</span>';
    private const  SECURITY_UNSAFE = '<span style="color: red">UNSAFE</span>';

    protected function resolve(array $data): Solution {
        $solution = (new Solution())->setInputLabel('Report')
                                    ->setCalculationLabel('Security');

        $safeReportsCounter = 0;

        foreach($data as $report) {
            $isSafe = true;

            $input = $this->style($report[0]);

            $ascending = $report[1] > $report[0];
            $min       = $ascending ? self::MIN_DIFF_LEVEL : -self::MAX_DIFF_LEVEL;
            $max       = $ascending ? self::MAX_DIFF_LEVEL : -self::MIN_DIFF_LEVEL;

            $i = 1;
            do {
                $levelDiff = $report[$i] - $report[$i - 1];

                if($levelDiff < $min || $levelDiff > $max) {
                    $input  .= $this->style($report[$i], ['color' => 'red']);
                    $isSafe = false;
                }
                else {
                    $input .= $this->style($report[$i]);
                }
                $i++;
            } while($i < sizeof($report));

            $calculation = '[' . ($isSafe ? self::SECURITY_OK : self::SECURITY_UNSAFE) . ']';
            $solution->addData($input, $calculation);

            $safeReportsCounter += $isSafe ? 1 : 0;
        }

        return $solution->setResult($safeReportsCounter);
    }

}

(new Day2Part1())->run();