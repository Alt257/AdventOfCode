<?php

namespace AOC\Advent2024\Day2;

use AOC\Entity\Solution;
use http\Exception\UnexpectedValueException;

require_once 'AbstractDay2.php';

class SafetyChecker {

    private bool $initialized = false;
    private bool $ascending   = true;
    private int  $min;
    private int  $max;
    private int  $reverseMin;
    private int  $reverseMax;

    function __construct(
        private int $absMin,
        private int $absMax,
    ) {}

    public function isSafe(int  $first,
                           int  $second,
                           bool $resetOrder = false,
    ) {
        $diff = $second - $first;

        if($resetOrder) {
            $this->resetOrder();
        }

        if(!$this->initialized) {
            if($diff == 0) {
                $this->initialized = false;
                return $this->absMin == 0;
            }
            else {
                $this->setAscending($diff > 0);
            }
        }

        return ($diff >= $this->min) && ($diff <= $this->max);
    }

    public function isSafeInReverseOrder(int $first,
                                         int $second,
    ) {
        $diff = $second - $first;

        if(!$this->initialized) {
            throw new UnexpectedValueException();
        }
        else {
            return ($diff >= $this->reverseMin) && ($diff <= $this->reverseMax);
        }
    }

    public function reverseOrder() {
        $this->setAscending(!$this->ascending);
    }

    private function resetOrder() {
        $this->initialized = false;
    }

    private function setAscending(bool $ascending) {
        $this->initialized = true;
        $this->ascending   = $ascending;

        if($ascending) {
            $this->min        = $this->absMin;
            $this->max        = $this->absMax;
            $this->reverseMin = -$this->absMax;
            $this->reverseMax = -$this->absMin;
        }
        else {
            $this->min        = -$this->absMax;
            $this->max        = -$this->absMin;
            $this->reverseMin = $this->absMin;
            $this->reverseMax = $this->absMax;
        }
    }

}

class Day2Part2 extends AbstractDay2 {

    protected const CSS_RED_NOSED_DATA     = [
        'font-weight'      => 'bold',
        'color'            => 'white',
        'background-color' => 'blue',
        'border-radius'    => '5px',
    ];
    protected const COLOR_SAFETY_ACTIVATED = 'blue';
    protected const COLOR_UNSAFE           = 'red';

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

            /////////////////////////////////////////////////////////////////////////////////////
            /*
            $safetyChecker = new SafetyChecker(self::MIN_DIFF_LEVEL, self::MAX_DIFF_LEVEL);
            
            for($i = 1; $i < sizeof($report); $i++) {
                $firstLoop = $i == 1;
                
                if(!$safetyChecker->isSafe($report[$i - 1], $report[$i])) {
                    if($redNosedSafety) {
                        $redNosedSafety--;
                        
                        if($i == (sizeof($report) - 1)) {
                            $solution->setDataStyle(self::CSS_RED_NOSED_DATA, 'Report', $reportNumber, $i);
                        }
                        else {
                            if($safetyChecker->isSafe($report[$i], $report[$i + 1], $firstLoop) && ($firstLoop || $safetyChecker->isSafe($report[$i - 2], $report[$i]))) {
                                $solution->setDataStyle(self::CSS_RED_NOSED_DATA, 'Report', $reportNumber, $i - 1);
                                $i++;
                            }
                            else if($safetyChecker->isSafe($report[$i - 1], $report[$i + 1], $firstLoop)) {
                                $solution->setDataStyle(self::CSS_RED_NOSED_DATA, 'Report', $reportNumber, $i);
                                $i++;
                            }
                            else {
                                $solution->setDataStyle(self::CSS_UNSAFE_DATA, 'Report', $reportNumber, $i);
                                $isSafe = false;
                            }
                        }
                    }
                    else {
                        $solution->setDataStyle(self::CSS_UNSAFE_DATA, 'Report', $reportNumber, $i);
                        $isSafe = false;
                    }
                }
                else if($firstLoop && $redNosedSafety && !$safetyChecker->isSafe($report[$i], $report[$i + 1]) && $safetyChecker->isSafeInReverseOrder($report[$i], $report[$i + 1])) {
                    $safetyChecker->reverseOrder();
                    $redNosedSafety--;
                    $solution->setDataStyle(self::CSS_RED_NOSED_DATA, 'Report', $reportNumber, $i - 1);
                    $i++;
                }
            }
            
            /*///////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/

            /*
                        if($this->isSafe($report[0], $report[1])) {

                            if(array_key_exists(2, $report)) {
                                $isAscending = $report[0] < $report[1];

                                if(!$this->isSafe($report[1], $report[2], $isAscending)) {
                                    $solution->setDataStyle(self::CSS_RED_NOSED_DATA,
                                                            'Report',
                                                            $reportNumber,
                                                            1,
                                    );

                                    if($this->isSafe($report[0], $report[2])) {
                                        $isAscending = $report[0] < $report[2];
                                    }
                                    else {
                                        $isSafe = false;
                                        $solution->setDataStyle(self::CSS_UNSAFE_DATA,
                                                                'Report',
                                                                $reportNumber,
                                                                2,
                                        );
                                    }
                                }
                            }
                        }
                        else {
                            $redNosedSafety--;
                            $solution->setDataStyle(self::CSS_RED_NOSED_DATA,
                                                    'Report',
                                                    $reportNumber,
                                                    1,
                            );

                            if(array_key_exists(2, $report)) {

                                if($this->isSafe($report[0], $report[2])) {
                                    $isAscending = $report[0] < $report[2];
                                }
                                else {
                                    $isSafe = false;
                                    $solution->setDataStyle(self::CSS_UNSAFE_DATA,
                                                            'Report',
                                                            $reportNumber,
                                                            2,
                                    );
                                }
                            }
                        }
            */
            $isAscending = $report[0] < $report[1];

            for($i = 1; $i < sizeof($report); $i++) {
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
                    if($this->isSafe($report[$i - 1] - $report[$i + 1], $isAscending)) {
                        $i++;
                        continue;
                    }
                    $i++;

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
                         . $this->col($order, '6em')
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