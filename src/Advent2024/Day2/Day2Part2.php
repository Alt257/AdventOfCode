<?php

namespace AOC\Advent2024\Day2;

use AOC\Entity\Solution;

require_once 'AbstractDay2.php';
require_once '..\..\Entity\Solution.php';

class Day2Part2 extends AbstractDay2 {

    function __construct() {
        parent::__construct(2);
    }

    protected function resolve(Solution $solution, array $data): int {

        $safeReportsCounter = 0;

        foreach($data as $report) {
            $redNosedSafety = 1;
            $isSafe         = true;

            $input = $this->style($report[0]);

            $ascending = $report[1] > $report[0];
            $min       = $ascending ? self::MIN_DIFF_LEVEL : -self::MAX_DIFF_LEVEL;
            $max       = $ascending ? self::MAX_DIFF_LEVEL : -self::MIN_DIFF_LEVEL;

            $i = 1;
            do {
                $levelDiff = $report[$i] - $report[$i - 1];

                if($levelDiff < $min || $levelDiff > $max) {

                    if($redNosedSafety > 0) {
                        $redNosedSafety--;
                        $input .= $this->style($report[$i], ['color' => 'purple', 'font-weight' => 'bold']);
                    }
                    else {
                        $input  .= $this->style($report[$i], ['color' => 'red']);
                        $isSafe = false;
                    }
                }
                else {
                    $input .= $this->style($report[$i]);
                }
                $i++;
            } while($i < sizeof($report));

            $calculation = '['
                . ($isSafe ? $this->style('OK', ['color' => 'green'])
                    : $this->style('UNSAFE', ['color' => 'red']))
                . ']';
            $solution->addData($input, $calculation);

            $safeReportsCounter += $isSafe ? 1 : 0;
        }

        return $safeReportsCounter;
    }

}

(new Day2Part2())->run();