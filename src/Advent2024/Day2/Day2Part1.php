<?php

namespace AOC\Advent2024\Day2;

require_once 'AbstractDay2.php';
require_once '../AbstractDay2024.php';

class Day2Part1 extends AbstractDay2 {

    private const  MIN_DIFF_LEVEL = 1;
    private const  MAX_DIFF_LEVEL = 3;

    private const  SECURITY_OK     = '<span style="color: green">OK</span>';
    private const  SECURITY_UNSAFE = '<span style="color: red">UNSAFE</span>';

    protected function resolve(array $data): int {
        $safeReportsCounter = 0;

        echo '<div style="max-height: 12em; overflow-y: auto; margin-bottom: 1em;">';
        echo '<table>';
        echo '<thead style="text-align: left"><tr><th>Report</th><th>Security</th></tr></thead>';
        foreach($data as $report) {
            $isSafe = true;

            echo '<tr>';
            echo '<td style="padding-right: 4em">' . $report[0] . ' ';

            $ascending = $report[1] > $report[0];
            $min       = $ascending ? self::MIN_DIFF_LEVEL : -self::MAX_DIFF_LEVEL;
            $max       = $ascending ? self::MAX_DIFF_LEVEL : -self::MIN_DIFF_LEVEL;

            $i = 1;
            do {
                $levelDiff = $report[$i] - $report[$i - 1];

                if($levelDiff < $min || $levelDiff > $max) {
                    echo '<span style="color: red">' . $report[$i] . ' </span>';
                    $isSafe = false;
                }
                else {
                    echo $report[$i] . ' ';
                }
                $i++;
            } while($i < sizeof($report));
            
            echo '</td>';
            echo '<td>&#91;' . ($isSafe ? self::SECURITY_OK : self::SECURITY_UNSAFE) . '&#93;</td>';
            echo '</tr>';

            $safeReportsCounter += $isSafe ? 1 : 0;
        }
        echo '</table>';
        echo '</div>';

        return $safeReportsCounter;
    }

}

(new Day2Part1())->run();