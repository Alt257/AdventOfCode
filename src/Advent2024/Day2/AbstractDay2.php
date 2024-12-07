<?php

namespace AOC\Advent2024\Day2;

use AOC\Advent2024\AbstractDay2024;

require_once '..\AbstractDay2024.php';

abstract class AbstractDay2 extends AbstractDay2024 {

    protected const  MIN_DIFF_LEVEL = 1;
    protected const  MAX_DIFF_LEVEL = 3;

    protected const CSS_UNSAFE = [
        'font-weight'      => 'bold',
        'color'            => 'white',
        'background-color' => 'red',
        'border-radius'    => '5px',
    ];

    public function __construct(?int $part = null) {
        parent::__construct(2, $part, 'Security');
    }

    protected function getData(array $rawData): array {
        $reportList = [];

        foreach($rawData as $row) {
            $report       = array_map(fn($level,
            ) => intval($level), explode(' ', $row));
            $reportList[] = $report;
        }

        return ['Report' => $reportList];
    }

}