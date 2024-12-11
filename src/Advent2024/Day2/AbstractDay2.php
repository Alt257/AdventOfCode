<?php

namespace AOC\Advent2024\Day2;

use AOC\Advent2024\AbstractDay2024;

require_once '..\AbstractDay2024.php';

abstract class AbstractDay2 extends AbstractDay2024 {

    protected const  MIN_LEVEL_DIFF = 1;
    protected const  MAX_LEVEL_DIFF = 3;

    protected const COLUMN_REPORT = 'Report';

    protected const CSS_UNSAFE_DATA = [
        'font-weight'      => 'bold',
        'color'            => 'white',
        'background-color' => 'red',
        'border-radius'    => '5px',
    ];
    protected const SAFE            = [
        'text' => 'SAFE',
        'css'  => [
            'color' => 'green',
        ],
    ];
    protected const UNSAFE          = [
        'text' => 'UNSAFE',
        'css'  => [
            'color' => 'red',
        ],
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

        return [self::COLUMN_REPORT => $reportList];
    }

}