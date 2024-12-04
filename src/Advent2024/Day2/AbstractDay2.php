<?php

namespace AOC\Advent2024\Day2;

use AOC\Advent2024\AbstractDay2024;
use AOC\Entity\Solution;

require_once '..\AbstractDay2024.php';

abstract class AbstractDay2 extends AbstractDay2024 {

    protected Solution $solution;

    public function __construct(?int $part = null) {
        parent::__construct('Report',
                            'Security',
                            2,
                            $part,
        );
    }

    protected function getData(array $rawData): array {
        $reportList = [];

        foreach($rawData as $row) {
            $report       = array_map(fn($level) => intval($level), explode(' ', $row));
            $reportList[] = $report;
        }

        return $reportList;
    }

}