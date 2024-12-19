<?php

namespace Advent2024\Day3;

use Advent2024\AbstractDay2024;

require_once '..\AbstractDay2024.php';

abstract class AbstractDay3 extends AbstractDay2024 {

    protected const COL_ROW          = 'row';
    protected const COL_INSTRUCTION_ = 'Instruction ';

    public function __construct(?int $part = null) {
        parent::__construct(3, $part, 'Total');
    }

    protected function getData(array $rawData): array {
        $instructionsList = [];

        foreach($rawData as $rowNum => $row) {
            preg_match_all('/mul\((\d{1,3}),(\d{1,3})\)/',
                           $row,
                           $matches,
            );
//            $instructionsList[self::COL_ROW][] = $row;
            foreach($matches[0] as $key => $match) {
                $instructionsList[self::COL_INSTRUCTION_ . $key][$rowNum] = [
                    $match,
                    $matches[1][$key] * $matches[2][$key],
                ];
            }
        }

        return $instructionsList;
    }

}