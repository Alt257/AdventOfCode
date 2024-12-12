<?php

namespace AOC\Advent2024\Day2;

use AOC\Entity\Solution;

require_once 'AbstractDay2.php';

class SafetyResult {

    function __construct(
        public readonly bool  $safe,
        public readonly bool  $ascending,
        public readonly array $annotations,
        public readonly int $lastIndex,
    ) {}

}

class DifferenceChecker {

    private bool $initialized = false;
    private bool $ascending   = true;
    private int  $min;
    private int  $max;

    function __construct(
        private readonly int $absMin,
        private readonly int $absMax,
    ) {}

    public function isAscending(): bool {
        return $this->ascending;
    }

    private function setAscending(bool $ascending): void {
        $this->initialized = true;
        $this->ascending   = $ascending;

        if($ascending) {
            $this->min = $this->absMin;
            $this->max = $this->absMax;
        }
        else {
            $this->min = -$this->absMax;
            $this->max = -$this->absMin;
        }
    }

    public function isSafe(?int $previous, int $current): bool {
        if($previous == null) {
            return true;
        }

        $diff = $current - $previous;

        if(!$this->initialized) {
            if($diff == 0) {
                return $this->absMin == 0;
            }
            else {
                $this->setAscending($diff > 0);
            }
        }

        return ($diff >= $this->min) && ($diff <= $this->max);
    }

}

class SafetyChecker {

    public const COLOR_SAFETY_ACTIVATED = 'blue';
    public const COLOR_UNSAFE           = 'red';

    function __construct(
        private readonly int $absMin,
        private readonly int $absMax,
    ) {}

    public function check(
        array $data,
        int   $redNoseSafety = 1,
        array $skippedIndexes = [],
    ): SafetyResult {
        $isSafe         = true;
        $annotations    = [];
        $previousIndex  = -1;
        $previousValue  = null;
        $differenceChecker = new DifferenceChecker($this->absMin, $this->absMax);

        foreach($data as $currentIndex => $currentValue) {
            if(!in_array($currentIndex, $skippedIndexes)) {
                if(!$differenceChecker->isSafe($previousValue, $currentValue)) {
                    if($redNoseSafety > 0) {
                        $resultIfRemovePrevious = $this->check($data, $redNoseSafety - 1, [...$skippedIndexes, $previousIndex]);

                        if($resultIfRemovePrevious->safe) {
                            return $resultIfRemovePrevious;
                        }

                        $resultIfRemoveCurrent = $this->check($data, $redNoseSafety - 1, [...$skippedIndexes, $currentIndex]);

                        if($resultIfRemoveCurrent->safe) {
                            return $resultIfRemoveCurrent;
                        }

                        return ($resultIfRemovePrevious->lastIndex > $resultIfRemoveCurrent->lastIndex) ? $resultIfRemovePrevious : $resultIfRemoveCurrent;
                    }

                    $isSafe                     = false;
                    $annotations[$currentIndex] = self::COLOR_UNSAFE;
                    $previousIndex = $currentIndex;
                    break;
                }

                $previousIndex = $currentIndex;
                $previousValue = $currentValue;
            }
            else {
                $annotations[$currentIndex] = self::COLOR_SAFETY_ACTIVATED;
            }
        }

        return new SafetyResult($isSafe, $differenceChecker->isAscending(), $annotations, $previousIndex);
    }

}

class Day2Part2Necron extends AbstractDay2 {

    function __construct() {
        parent::__construct(2);
        $this->addSolution(
            'Custom', [
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
        ],
        );
    }

    protected function resolve(
        Solution $solution,
        array    $data,
    ): int {
        $safeReportsCounter = 0;
        $safetyChecker      = new SafetyChecker(self::MIN_LEVEL_DIFF, self::MAX_LEVEL_DIFF);

        foreach($data['Report'] as $reportNumber => $report) {
            $safetyResult = $safetyChecker->check($report);

            foreach($safetyResult->annotations as $index => $annotation) {
                $solution->highlightData($annotation, self::COLUMN_REPORT, $reportNumber, $index);
            }

            //@formatter:off
            $security = '['
                      . $this->style($safetyResult->safe ? self::SAFE : self::UNSAFE)
                      . ']';
            $order = $safetyResult->ascending ? 'Ascending' : 'Descending';

            $calculation = $this->col($security, '6em')
                         . $this->col($order, '6em')
            ;
            //@formatter:on
            $solution->setCalculation($reportNumber, $calculation);

            if($safetyResult->safe) {
                $safeReportsCounter++;
            }
        }

        return $safeReportsCounter;
    }

}

(new Day2Part2Necron())->run();